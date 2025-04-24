<?php

class Order
{
    use Model;

    protected $table = 'pharmacy_orders';

    private $last_error = null;

    public function getLastError() {
        if ($this->last_error) {
            return $this->last_error;
        }
        
        // Try to get the last database error if available
        if (method_exists($this, 'connect')) {
            $db = $this->connect();
            if ($db) {
                return $db->errorInfo()[2];
            }
        }
        
        return "Unknown error";
    }

    public function getPendingOrders($pharmacy_id)
    {
        $query = "SELECT 
            po.order_id,
            po.owner_id,
            pet_o.f_name as customer_name,
            p.pet_name as pet_name,
            p.pet_type as pet_type,
            om.med_id,
            m.med_name as medicine,
            om.quantity,
            po.total_price,
            po.order_date,
            po.status
        FROM pharmacy_orders po
        JOIN pet_owner pet_o ON po.owner_id = pet_o.owner_id
        JOIN pets p ON po.pet_id = p.pet_id
        JOIN order_medicines om ON po.order_id = om.order_id
        JOIN medicine m ON om.med_id = m.med_id
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
            om.med_id,
            m.med_name as medicine,
            om.quantity,
            po.total_price,
            po.processed_date,
            po.status,
            po.payment_status,
            po.payment_date,
            po.decline_reason
        FROM pharmacy_orders po
        JOIN pet_owner pet_o ON po.owner_id = pet_o.owner_id
        JOIN pets p ON po.pet_id = p.pet_id
        JOIN order_medicines om ON po.order_id = om.order_id
        JOIN medicine m ON om.med_id = m.med_id
        WHERE po.pharmacy_id = :pharmacy_id 
        AND po.status IN ('accepted', 'declined')
        ORDER BY po.processed_date DESC";

        $results = $this->query($query, [':pharmacy_id' => $pharmacy_id]);

        // Organize results to include medicines in an array
        $orders = [];
        foreach ($results as $row) {
            $order_id = $row->order_id;
            if (!isset($orders[$order_id])) {
                $orders[$order_id] = (object) [
                    'order_id' => $order_id,
                    'customer_name' => $row->customer_name,
                    'pet_name' => $row->pet_name,
                    'pet_type' => $row->pet_type,
                    'medicines' => [], // Initialize as an empty array
                    'total_price' => $row->total_price,
                    'processed_date' => $row->processed_date,
                    'status' => $row->status,
                    'payment_status' => $row->payment_status,
                    'payment_date' => $row->payment_date,
                    'decline_reason' => $row->decline_reason,
                ];
            }
            // Add medicine details to the order
            $orders[$order_id]->medicines[] = (object) [
                'med_id' => $row->med_id,
                'med_name' => $row->medicine,
                'quantity' => $row->quantity,
            ];
        }

        return array_values($orders); // Return as a simple array
    }

    public function updateOrderStatus($order_id, $status, $decline_reason = null)
    {
        try {
            // Start transaction
            $db = $this->connect();
            $db->beginTransaction();

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

                $stmt = $db->prepare($sql);
                $result = $stmt->execute($params);
                
                if ($result === false) {
                    throw new Exception("Database query failed");
                }

                // Get order details to create notification
                $orderQuery = "SELECT owner_id, pharmacy_id FROM pharmacy_orders WHERE order_id = :order_id";
                $orderStmt = $db->prepare($orderQuery);
                $orderStmt->execute([':order_id' => $order_id]);
                $orderDetails = $orderStmt->fetch(PDO::FETCH_OBJ);

                if ($orderDetails) {
                    // Create notification
                    $notification = new Notification();
                    $notificationData = [
                        'user_id' => $orderDetails->owner_id,
                        'reference_id' => $order_id,
                        'type' => $status === 'accepted' ? 'order_accepted' : 'order_declined',
                        'message' => $status === 'accepted' 
                            ? "Your order #$order_id has been accepted by the pharmacy. Please proceed with payment."
                            : "Your order #$order_id has been declined. Reason: " . ($decline_reason ?? 'No reason provided')
                    ];

                    $notification->createNotification($notificationData);
                }

                // Commit transaction
                $db->commit();
                return true;

            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            
        } catch (Exception $e) {
            $this->last_error = $e->getMessage();
            error_log("Error in updateOrderStatus: " . $e->getMessage());
            return false;
        }
    }

    public function getRecentOrders($pharmacy_id, $limit = 20)
    {
        $query = "SELECT 
            po.order_id,
            pet_o.f_name as customer_name,
            p.pet_name as pet_name,
            p.pet_type as pet_type,
            om.med_id,
            m.med_name as medicine,
            om.quantity,
            po.total_price,
            po.order_date,
            po.status,
            po.prescription_id,
            pr.created_at as prescription_date,
            vs.f_name as vet_name
        FROM pharmacy_orders po
        JOIN pet_owner pet_o ON po.owner_id = pet_o.owner_id
        JOIN pets p ON po.pet_id = p.pet_id
        JOIN order_medicines om ON po.order_id = om.order_id
        JOIN medicine m ON om.med_id = m.med_id
        LEFT JOIN prescription pr ON po.prescription_id = pr.prescription_id
        LEFT JOIN veterinary_surgeon vs ON pr.vet_id = vs.vet_id
        WHERE po.pharmacy_id = :pharmacy_id 
        AND (po.status = 'pending' OR po.order_date >= DATE_SUB(NOW(), INTERVAL 7 DAY))
        ORDER BY 
            CASE 
                WHEN po.status = 'pending' THEN 0
                ELSE 1
            END,
            po.order_date DESC
        LIMIT " . (int)$limit;

        $results = $this->query($query, [':pharmacy_id' => $pharmacy_id]);

        // Organize results to include medicines in an array
        $orders = [];
        foreach ($results as $row) {
            $order_id = $row->order_id;
            if (!isset($orders[$order_id])) {
                $orders[$order_id] = (object) [
                    'order_id' => $order_id,
                    'customer_name' => $row->customer_name,
                    'pet_name' => $row->pet_name,
                    'pet_type' => $row->pet_type,
                    'medicines' => [], // Initialize as an empty array
                    'total_price' => $row->total_price,
                    'order_date' => $row->order_date,
                    'status' => $row->status,
                    'prescription_id' => $row->prescription_id,
                    'prescription_date' => $row->prescription_date,
                    'vet_name' => $row->vet_name
                ];
            }
            // Add medicine details to the order
            $orders[$order_id]->medicines[] = (object) [
                'med_id' => $row->med_id,
                'med_name' => $row->medicine,
                'quantity' => $row->quantity,
            ];
        }

        return array_values($orders); // Return as a simple array
    }

    public function getOrderStats($pharmacy_id)
    {
        $query = "SELECT 
            COUNT(DISTINCT po.order_id) as total_orders,
            SUM(CASE WHEN po.status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
            SUM(CASE WHEN po.status = 'accepted' THEN 1 ELSE 0 END) as accepted_orders,
            SUM(CASE WHEN po.status = 'declined' THEN 1 ELSE 0 END) as declined_orders,
            COALESCE(SUM(CASE WHEN po.payment_status = 'paid' THEN po.total_price ELSE 0 END), 0) as total_revenue
        FROM pharmacy_orders po 
        WHERE po.pharmacy_id = :pharmacy_id";

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

    public function updatePaymentStatusAndDate($order_id, $status)
    {
        try {
            // Log the incoming parameters
            error_log("Updating payment status - Order ID: " . $order_id . ", New Status: " . $status);

            $params = [
                ':order_id' => $order_id,
                ':status' => $status,
                ':payment_date' => $status === 'paid' ? date('Y-m-d H:i:s') : null
            ];

            // Log the query parameters
            error_log("Query parameters: " . print_r($params, true));

            $query = "UPDATE pharmacy_orders 
                      SET payment_status = :status,
                          payment_date = :payment_date
                      WHERE order_id = :order_id";
            
            // Execute the query and get the result
            $result = $this->query($query, $params);
            
            // Log the result
            error_log("Query result: " . ($result ? "Success" : "Failed"));
            
            if (!$result) {
                error_log("Database error: " . $this->getLastError());
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Database error in updatePaymentStatusAndDate: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function createOrder($data)
    {
        try {
            // Debug log
            error_log("Starting order creation with data: " . print_r($data, true));

            // Start a transaction
            $db = $this->connect();
            $db->beginTransaction();

            try {
                // Get pet owner's name for the notification
                $ownerQuery = "SELECT f_name FROM pet_owner WHERE owner_id = :owner_id";
                $ownerStmt = $db->prepare($ownerQuery);
                $ownerStmt->execute([':owner_id' => $data['owner_id']]);
                $owner = $ownerStmt->fetch(PDO::FETCH_OBJ);

                // Prepare order data
                $query = "INSERT INTO pharmacy_orders 
                          (owner_id, pharmacy_id, pet_id, total_price, order_date, status, payment_status, notes, prescription_id, created_at) 
                          VALUES 
                          (:owner_id, :pharmacy_id, :pet_id, :total_price, NOW(), 'pending', 'pending', :notes, :prescription_id, NOW())";

                $params = [
                    ':owner_id' => $data['owner_id'],
                    ':pharmacy_id' => $data['pharmacy_id'],
                    ':pet_id' => $data['pet_id'],
                    ':total_price' => $data['total_price'],
                    ':notes' => $data['notes'] ?? null,
                    ':prescription_id' => $data['prescription_id'] ?? null
                ];

                // Debug log
                error_log("Executing order insert with params: " . print_r($params, true));

                // Execute the main order insert
                $stmt = $db->prepare($query);
                $stmt->execute($params);

                // Get the last insert ID immediately after the insert
                $order_id = $db->lastInsertId();
                error_log("Order created with ID: " . $order_id);

                if (!$order_id) {
                    throw new Exception("Failed to get order ID after insert");
                }

                // Insert medicines
                $medicineQuery = "INSERT INTO order_medicines (order_id, med_id, quantity) 
                                VALUES (:order_id, :med_id, :quantity)";
                
                $medicineStmt = $db->prepare($medicineQuery);

                foreach ($data['medicines'] as $medicine) {
                    $paramsMedicine = [
                        ':order_id' => $order_id,
                        ':med_id' => $medicine['med_id'],
                        ':quantity' => $medicine['quantity']
                    ];
                    
                    error_log("Inserting medicine with params: " . print_r($paramsMedicine, true));
                    $medicineStmt->execute($paramsMedicine);
                }

                // Create notification for the pharmacy
                $notification = new Notification();
                $notificationData = [
                    'user_id' => $data['pharmacy_id'],
                    'reference_id' => $order_id,
                    'type' => 'new_order',
                    'message' => "New order received from customer " . ($owner->f_name ?? 'Unknown')
                ];
                $notification->createNotification($notificationData);

                // If we get here, everything worked, so commit the transaction
                $db->commit();
                error_log("Transaction committed successfully");

                return [
                    'success' => true,
                    'order_id' => $order_id,
                    'message' => 'Order created successfully'
                ];

            } catch (Exception $e) {
                // Something went wrong, rollback the transaction
                $db->rollBack();
                error_log("Transaction rolled back: " . $e->getMessage());
                throw $e; // Re-throw to be caught by outer catch
            }

        } catch (Exception $e) {
            error_log("Error in createOrder: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            return [
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ];
        }
    }

    public function getSalesReport($pharmacy_id, $start_date, $end_date)
    {
        try {
            $query = "SELECT 
                COUNT(DISTINCT po.order_id) as total_orders,
                COALESCE(SUM(CASE WHEN po.payment_status = 'paid' THEN po.total_price ELSE 0 END), 0) as total_revenue,
                COALESCE(AVG(CASE WHEN po.payment_status = 'paid' THEN po.total_price ELSE NULL END), 0) as average_order_value,
                COUNT(CASE WHEN po.status = 'accepted' THEN 1 END) as accepted_orders,
                COUNT(CASE WHEN po.status = 'declined' THEN 1 END) as declined_orders,
                COUNT(CASE WHEN po.payment_status = 'paid' THEN 1 END) as paid_orders,
                COUNT(CASE WHEN po.status = 'accepted' AND po.payment_status = 'pending' THEN 1 END) as pending_payments
            FROM pharmacy_orders po 
            WHERE po.pharmacy_id = :pharmacy_id 
            AND (po.payment_date BETWEEN :start_date AND :end_date OR po.payment_status = 'pending')";

            $params = [
                ':pharmacy_id' => $pharmacy_id,
                ':start_date' => $start_date,
                ':end_date' => $end_date
            ];

            $result = $this->query($query, $params);
            return $result[0] ?? null;
        } catch (Exception $e) {
            error_log("Error in getSalesReport: " . $e->getMessage());
            throw $e;
        }
    }

    public function getMedicineSalesReport($pharmacy_id, $start_date, $end_date)
    {
        try {
            $query = "SELECT 
                m.med_id,
                m.med_name,
                COUNT(DISTINCT po.order_id) as order_count,
                SUM(om.quantity) as total_quantity,
                COALESCE(SUM(om.quantity * m.price), 0) as total_revenue
            FROM pharmacy_orders po
            JOIN order_medicines om ON po.order_id = om.order_id
            JOIN medicine m ON om.med_id = m.med_id
            WHERE po.pharmacy_id = :pharmacy_id 
            AND po.status = 'accepted'
            AND (po.payment_status = 'paid' OR po.payment_date IS NOT NULL)
            AND (po.payment_date BETWEEN :start_date AND :end_date OR po.payment_date IS NULL)
            GROUP BY m.med_id, m.med_name
            ORDER BY total_revenue DESC";

            $params = [
                ':pharmacy_id' => $pharmacy_id,
                ':start_date' => $start_date,
                ':end_date' => $end_date
            ];

            // Debug log
            error_log("Executing medicine sales report query with params: " . print_r($params, true));
            error_log("SQL Query: " . $query);
            
            $results = $this->query($query, $params);
            error_log("Query results: " . print_r($results, true));

            return $results;
        } catch (Exception $e) {
            error_log("Error in getMedicineSalesReport: " . $e->getMessage());
            throw $e;
        }
    }

    public function getMedicineSalesWithoutOrderMedicines($pharmacy_id, $start_date, $end_date)
    {
        try {
            $query = "SELECT 
                m.med_id,
                m.med_name,
                COUNT(DISTINCT po.order_id) as order_count,
                SUM(JSON_EXTRACT(po.medicines, '$[*].quantity')) as total_quantity,
                COALESCE(SUM(JSON_EXTRACT(po.medicines, '$[*].quantity') * m.unit_price), 0) as total_revenue
            FROM pharmacy_orders po
            JOIN medicine m ON JSON_CONTAINS(po.medicines, CAST(CONCAT('{\"med_id\":', m.med_id, '}') AS JSON), '$[*]')
            WHERE po.pharmacy_id = :pharmacy_id 
            AND po.payment_status = 'paid'
            AND po.payment_date BETWEEN :start_date AND :end_date
            GROUP BY m.med_id, m.med_name
            ORDER BY total_revenue DESC";

            $params = [
                ':pharmacy_id' => $pharmacy_id,
                ':start_date' => $start_date,
                ':end_date' => $end_date
            ];

            // Debug log
            error_log("Executing medicine sales report query without order_medicines table with params: " . print_r($params, true));
            $results = $this->query($query, $params);
            error_log("Query results: " . print_r($results, true));

            return $results;
        } catch (Exception $e) {
            error_log("Error in getMedicineSalesWithoutOrderMedicines: " . $e->getMessage());
            throw $e;
        }
    }
} 