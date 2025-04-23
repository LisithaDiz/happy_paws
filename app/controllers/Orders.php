<?php

class Orders
{
    use Controller;

    public function index()
    {
        $order = new Order();
        
        // Assuming you have a session or a method to get the logged-in user's pharmacy_id
        $pharmacy_id = $_SESSION['pharmacy_id']; // Replace this with your actual method to get the pharmacy_id

        $data = [
            'recent_orders' => $order->getRecentOrders($pharmacy_id),
            'order_stats' => $order->getOrderStats($pharmacy_id)
        ];

        $this->view('orders', $data);
    }

    public function updateStatus()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        try {
            $order = new Order();
            
            $order_id = $_POST['order_id'] ?? '';
            $status = $_POST['status'] ?? '';
            $decline_reason = $_POST['decline_reason'] ?? null;

            // Validate inputs
            if (empty($order_id) || empty($status)) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Order ID and status are required'
                ]);
                return;
            }

            if ($status === 'declined' && empty($decline_reason)) {
                echo json_encode(['success' => false, 'message' => 'Decline reason is required']);
                return;
            }

            $result = $order->updateOrderStatus($order_id, $status, $decline_reason);
            
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Failed to update order status'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
        exit;
    }

    public function createOrder($pharmacy_id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        try {
            $order = new Order();
            $medicineModel = new MedicineModel(); // Use the correct model name
            $medicines = $medicineModel->getAllMedicines(); // Fetch all medicines

            // Get and validate POST data
            $data = [
                'owner_id' => $_SESSION['owner_id'], // Ensure this is the correct owner ID
                'pharmacy_id' => $pharmacy_id, // Use the pharmacy ID from the URL
                'pet_id' => $_POST['pet_id'],
                'total_price' => $_POST['total_price'],
                'notes' => $_POST['notes'] ?? null, // Include notes if provided
                'medicines' => []
            ];

            // Prepare medicines data
            foreach ($_POST['medicines'] as $index => $med_id) {
                $data['medicines'][] = [
                    'med_id' => $med_id,
                    'quantity' => $_POST['quantities'][$index]
                ];
            }

            // Create the order
            $result = $order->createOrder($data);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }
}