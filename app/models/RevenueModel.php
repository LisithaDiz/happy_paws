<?php

class RevenueModel
{
    use Model;

    protected $table = 'pharmacy_orders';

    // Create monthly_revenue_details table if it doesn't exist
    public function createMonthlyRevenueTable()
    {
        

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
        // Debug: Log the current year
        error_log("Current year: " . date('Y'));
        
        // Get all months with orders for the current year
        $query = "SELECT 
            DATE_FORMAT(po.payment_date, '%Y-%m-01') as month,
            SUM(po.total_price) as revenue,
            COUNT(DISTINCT po.order_id) as orders,
            (
                SELECT m.med_name
                FROM order_medicines om
                JOIN medicine m ON om.med_id = m.med_id
                WHERE om.order_id IN (
                    SELECT order_id 
                    FROM pharmacy_orders 
                    WHERE pharmacy_id = :pharmacy_id 
                    AND DATE_FORMAT(payment_date, '%Y-%m-01') = DATE_FORMAT(po.payment_date, '%Y-%m-01')
                )
                GROUP BY m.med_id, m.med_name
                ORDER BY SUM(om.quantity) DESC
                LIMIT 1
            ) as top_product
        FROM pharmacy_orders po
        WHERE po.pharmacy_id = :pharmacy_id
        AND po.payment_status = 'paid'
        AND po.status = 'accepted'
        AND po.payment_date IS NOT NULL
        GROUP BY DATE_FORMAT(po.payment_date, '%Y-%m-01')
        ORDER BY month DESC";

        // Debug: Log the query
        error_log("Revenue query: " . $query);
        
        $results = $this->query($query, [':pharmacy_id' => $pharmacy_id]);
        
        // Debug: Log the results
        error_log("Query results: " . print_r($results, true));
        
        // Debug: Check for April orders specifically
        $april_query = "SELECT 
            DATE_FORMAT(payment_date, '%Y-%m-%d') as payment_date,
            payment_status,
            status,
            total_price
        FROM pharmacy_orders 
        WHERE pharmacy_id = :pharmacy_id
        AND MONTH(payment_date) = 4 
        AND YEAR(payment_date) = YEAR(CURDATE())";
        
        $april_results = $this->query($april_query, [':pharmacy_id' => $pharmacy_id]);
        error_log("April orders: " . print_r($april_results, true));

        // Calculate growth for each month
        $monthly_data = [];
        foreach ($results as $index => $row) {
            $growth = 0;
            if ($index < count($results) - 1) {
                $prev_revenue = $results[$index + 1]->revenue;
                if ($prev_revenue > 0) {
                    $growth = (($row->revenue - $prev_revenue) / $prev_revenue) * 100;
                }
            }

            // Insert or update monthly revenue data
            $insert_query = "INSERT INTO monthly_revenue_details 
                (pharmacy_id, month, revenue, orders, top_product, growth)
                VALUES (:pharmacy_id, :month, :revenue, :orders, :top_product, :growth)
                ON DUPLICATE KEY UPDATE
                revenue = VALUES(revenue),
                orders = VALUES(orders),
                top_product = VALUES(top_product),
                growth = VALUES(growth)";

            $this->query($insert_query, [
                ':pharmacy_id' => $pharmacy_id,
                ':month' => $row->month,
                ':revenue' => $row->revenue,
                ':orders' => $row->orders,
                ':top_product' => $row->top_product,
                ':growth' => $growth
            ]);
        }

        return true;
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
            SUM(po.total_price) as total_revenue,
            AVG(po.total_price) as monthly_average,
            COUNT(*) as total_orders
        FROM pharmacy_orders po
        WHERE po.pharmacy_id = :pharmacy_id 
        AND po.payment_status = 'paid'
        AND po.status = 'accepted'
        AND po.payment_date IS NOT NULL";

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
        AND po.payment_date IS NOT NULL
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

    public function getTopProducts($pharmacy_id)
    {
        try {
            $query = "SELECT 
                        m.med_id,
                        m.med_name as medicine_name,
                        COUNT(DISTINCT po.order_id) as total_orders,
                        COALESCE(SUM(om.quantity), 0) as total_quantity,
                        COALESCE(SUM(m.price * om.quantity), 0) as total_revenue
                    FROM medicine m
                    INNER JOIN order_medicines om ON m.med_id = om.med_id
                    INNER JOIN pharmacy_orders po ON om.order_id = po.order_id 
                        AND po.pharmacy_id = :pharmacy_id
                        AND po.payment_status = 'paid'
                        AND po.status = 'accepted'
                        AND po.payment_date IS NOT NULL
                    GROUP BY m.med_id, m.med_name
                    ORDER BY total_quantity DESC";

            $result = $this->query($query, [':pharmacy_id' => $pharmacy_id]);
            
            // Debug: Log the results
            error_log("Top Products results: " . print_r($result, true));
            
            return is_array($result) ? $result : [];
        } catch (Exception $e) {
            error_log("Error in getTopProducts: " . $e->getMessage());
            return [];
        }
    }
} 