<?php

class OrderHistory
{
    use Controller;

    public function index()
    {
        $order = new Order();
        
        // Fetch processed orders for the pharmacy
        $pharmacy_id = $_SESSION['pharmacy_id'];

        $data = [
            'orders' => $order->getProcessedOrders($pharmacy_id),
        ];

        $this->view('orderhistory', $data);
    }

    public function updatePayment()
    {
        // Clear any previous output
        if (ob_get_length()) ob_clean();
        
        // Set proper JSON headers
        header('Content-Type: application/json; charset=utf-8');
        
        try {
            // Log the raw request
            error_log("Raw request: " . file_get_contents('php://input'));

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                throw new Exception('Invalid request method');
            }

            // Get and validate POST data
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON data received');
            }

            $order_id = $data['order_id'] ?? null;

            if (!$order_id) {
                throw new Exception('Missing order ID');
            }

            // Log the order ID
            error_log("Processing payment update for order ID: " . $order_id);

            $order = new Order();
            
            // Verify order exists
            $orderInfo = $order->getOrderById($order_id);
            if (!$orderInfo) {
                throw new Exception('Order not found');
            }

            $result = $order->updatePaymentStatus($order_id, 'paid');
            
            if ($result) {
                $response = [
                    'success' => true,
                    'message' => 'Payment status updated successfully'
                ];
            } else {
                throw new Exception('Failed to update payment status');
            }
            
            // Log the response
            error_log("Sending response: " . json_encode($response));
            
            // Send response
            echo json_encode($response);
            
        } catch (Exception $e) {
            error_log("Payment update error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        
        // Ensure no other output
        exit();
    }

    public function markAsPaid()
    {
        // Clear any previous output
        if (ob_get_length()) ob_clean();
        
        try {
            // Get POST data directly
            $order_id = $_POST['order_id'] ?? null;

            if (!$order_id) {
                throw new Exception('Missing order ID');
            }

            $order = new Order();
            $result = $order->updatePaymentStatus($order_id, 'paid');
            
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception('Failed to update payment status');
            }
            
        } catch (Exception $e) {
            error_log("Payment update error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit();
    }
}