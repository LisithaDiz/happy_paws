<?php

class Order
{
    use Model;

    protected $table = 'pharmacy_orders';

    private $last_error = null;

    public function getLastError() {
        return $this->last_error;
    }

    public function getPendingOrders($pharmacy_id)
    {
        $query = "SELECT 
            po.order_id,
            po.owner_id,
            pet_o.f_name as customer_name,
            p.pet_name as pet_name,
            p.pet_type as pet_type,
            m.med_name as medicine,
            po.quantity,
            po.total_price,
            po.order_date,
            po.status
        FROM pharmacy_orders po
        JOIN pet_owner pet_o ON po.owner_id = pet_o.owner_id
        JOIN pet p ON po.pet_id = p.pet_id
        JOIN medicine m ON po.med_id = m.med_id
        WHERE po.pharmacy_id = :pharmacy_id 
        AND po.status = 'pending'
        ORDER BY po.order_date DESC";

        return $this->query($query, [':pharmacy_id' => $pharmacy_id]);
    }

    public function getProcessedOrders($pharmacy_id)
    {
        $query = "SELECT 
            po.order_id,
            pet_o.f_name as customer_name,
            p.pet_name as pet_name,
            p.pet_type as pet_type,
            m.med_name as medicine,
            po.quantity,
            po.total_price,
            po.processed_date,
            po.status,
            po.payment_status,
            po.decline_reason
        FROM pharmacy_orders po
        JOIN pet_owner pet_o ON po.owner_id = pet_o.owner_id
        JOIN pet p ON po.pet_id = p.pet_id
        JOIN medicine m ON po.med_id = m.med_id
        WHERE po.pharmacy_id = :pharmacy_id 
        AND po.status IN ('accepted', 'declined')
        ORDER BY po.processed_date DESC";

        return $this->query($query, [':pharmacy_id' => $pharmacy_id]);
    }

    public function updateOrderStatus($order_id, $status, $decline_reason = null)
    {
        try {
            $params = [
                ':order_id' => $order_id,
                ':status' => $status,
                ':processed_date' => date('Y-m-d H:i:s')
            ];

            $sql = "UPDATE pharmacy_orders 
                    SET status = :status, 
                        processed_date = :processed_date";

            if ($status === 'declined' && $decline_reason) {
                $sql .= ", decline_reason = :decline_reason";
                $params[':decline_reason'] = $decline_reason;
            }

            $sql .= " WHERE order_id = :order_id";

            // Debug: Log the SQL query and parameters
            error_log("Executing SQL: " . $sql);
            error_log("Parameters: " . print_r($params, true));

            $result = $this->query($sql, $params);
            
            if ($result === false) {
                $this->last_error = "Database query failed";
                return false;
            }
            
            return true;
        } catch (Exception $e) {
            $this->last_error = $e->getMessage();
            error_log("Error in updateOrderStatus: " . $e->getMessage());
            return false;
        }
    }

    public function getRecentOrders($pharmacy_id, $limit = 5)
    {
        $query = "SELECT 
            po.order_id,
            pet_o.f_name as customer_name,
            p.pet_name as pet_name,
            p.pet_type as pet_type,
            m.med_name as medicine,
            po.quantity,
            po.total_price,
            po.order_date,
            po.status
        FROM pharmacy_orders po
        JOIN pet_owner pet_o ON po.owner_id = pet_o.owner_id
        JOIN pet p ON po.pet_id = p.pet_id
        JOIN medicine m ON po.med_id = m.med_id
        WHERE po.pharmacy_id = :pharmacy_id 
        ORDER BY po.order_date DESC
        LIMIT " . (int)$limit;

        return $this->query($query, [':pharmacy_id' => $pharmacy_id]);
    }

    public function getOrderStats($pharmacy_id)
    {
        $query = "SELECT 
            COUNT(*) as total_orders,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
            SUM(CASE WHEN status = 'accepted' THEN 1 ELSE 0 END) as accepted_orders,
            SUM(CASE WHEN status = 'declined' THEN 1 ELSE 0 END) as declined_orders,
            COALESCE(SUM(total_price), 0) as total_revenue
        FROM pharmacy_orders 
        WHERE pharmacy_id = :pharmacy_id";

        $result = $this->query($query, [':pharmacy_id' => $pharmacy_id]);
        return $result[0] ?? [
            'total_orders' => 0,
            'pending_orders' => 0,
            'accepted_orders' => 0,
            'declined_orders' => 0,
            'total_revenue' => 0
        ];
    }

    public function updatePaymentStatus($order_id, $status)
    {
        try {
            $query = "UPDATE pharmacy_orders 
                      SET payment_status = :status 
                      WHERE order_id = :order_id";
            
            return $this->query($query, [
                ':status' => $status,
                ':order_id' => $order_id
            ]);
        } catch (Exception $e) {
            error_log("Database error in updatePaymentStatus: " . $e->getMessage());
            return false;
        }
    }

    public function getOrderById($order_id)
    {
        try {
            $query = "SELECT * FROM pharmacy_orders WHERE order_id = :order_id LIMIT 1";
            $result = $this->query($query, [':order_id' => $order_id]);
            
            return $result ? $result[0] : null;
        } catch (Exception $e) {
            error_log("Database error in getOrderById: " . $e->getMessage());
            return null;
        }
    }
} 