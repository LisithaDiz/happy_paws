<?php

class RevenueModel
{
    use Model;

    protected $table = 'pharmacy_orders';

    // Create monthly_revenue_details table if it doesn't exist
    public function createMonthlyRevenueTable()
    {
        // Drop the existing table first
        $drop_query = "DROP TABLE IF EXISTS monthly_revenue_details";
        $this->query($drop_query);

        // Create the table with all required columns
        $query = "CREATE TABLE monthly_revenue_details (
            id INT PRIMARY KEY AUTO_INCREMENT,
            pharmacy_id INT,
            month DATE,
            revenue DECIMAL(10,2),
            orders INT,
            top_product VARCHAR(100),
            growth DECIMAL(5,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (pharmacy_id) REFERENCES pharmacy(pharmacy_id)
        )";

        // Add unique index to prevent duplicate months for same pharmacy
        $index_query = "ALTER TABLE monthly_revenue_details 
                       ADD UNIQUE INDEX idx_pharmacy_month (pharmacy_id, month)";

        $this->query($query);
        $this->query($index_query);
        
        return true;
    }

    // Calculate and store monthly revenue details
    public function updateMonthlyRevenue($pharmacy_id)
    {
        $query = "SELECT 
            SUM(om.quantity * m.price) AS total_revenue
        FROM pharmacy_orders po
        JOIN order_medicines om ON po.order_id = om.order_id
        JOIN medicine m ON om.med_id = m.med_id
        WHERE po.pharmacy_id = :pharmacy_id
        AND MONTH(po.processed_date) = MONTH(CURRENT_DATE())
        AND YEAR(po.processed_date) = YEAR(CURRENT_DATE())";

        return $this->query($query, [':pharmacy_id' => $pharmacy_id]);
    }

    // Get monthly revenue details for display
    public function getMonthlyRevenueDetails($pharmacy_id)
    {
        $query = "SELECT 
            DATE_FORMAT(month, '%M %Y') as month,
            revenue,
            orders,
            top_product,
            growth
        FROM monthly_revenue_details
        WHERE pharmacy_id = :pharmacy_id
        ORDER BY month DESC
        LIMIT 12";

        $results = $this->query($query, [':pharmacy_id' => $pharmacy_id]);
        
        // Convert objects to arrays and ensure all fields exist
        $monthly_data = [];
        foreach ($results as $row) {
            $monthly_data[] = [
                'month' => $row->month,
                'revenue' => (float)$row->revenue,
                'orders' => (int)$row->orders,
                'top_product' => $row->top_product ?? 'N/A',
                'growth' => (float)$row->growth
            ];
        }
        
        return $monthly_data;
    }

    // Get summary statistics
    public function getRevenueSummary($pharmacy_id)
    {
        $query = "SELECT 
            SUM(om.quantity * m.price) as total_revenue,
            AVG(po.total_price) as monthly_average,
            COUNT(*) as total_orders
        FROM pharmacy_orders po
        JOIN order_medicines om ON po.order_id = om.order_id
        JOIN medicine m ON om.med_id = m.med_id
        WHERE po.pharmacy_id = :pharmacy_id 
        AND po.payment_status = 'paid'
        AND po.status = 'accepted'
        AND po.processed_date IS NOT NULL";

        $result = $this->query($query, [':pharmacy_id' => $pharmacy_id]);

        // Get top selling product overall
        $top_product_query = "SELECT 
            m.med_name as name,
            COUNT(*) as units
        FROM order_medicines om
        JOIN pharmacy_orders po ON om.order_id = po.order_id
        JOIN medicine m ON om.med_id = m.med_id
        WHERE po.pharmacy_id = :pharmacy_id 
        AND po.payment_status = 'paid'
        AND po.status = 'accepted'
        AND po.processed_date IS NOT NULL
        GROUP BY m.med_id, m.med_name
        ORDER BY units DESC
        LIMIT 1";

        $top_product = $this->query($top_product_query, [':pharmacy_id' => $pharmacy_id]);

        // Convert to array format with proper type casting
        return [
            'total_revenue' => (float)($result[0]->total_revenue ?? 0),
            'monthly_average' => (float)($result[0]->monthly_average ?? 0),
            'total_orders' => (int)($result[0]->total_orders ?? 0),
            'top_product' => [
                'name' => $top_product[0]->name ?? 'N/A',
                'units' => (int)($top_product[0]->units ?? 0)
            ]
        ];
    }
} 