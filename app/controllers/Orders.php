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
        $order = new Order();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // For decline action
            $order_id = $_POST['order_id'];
            $reason = $_POST['decline_reason'];
            $notes = $_POST['notes'];
            
            $result = $order->updateOrderStatus($order_id, 'declined', $reason, $notes);
            if ($result) {
                redirect('orders');
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['order_id']) && isset($_GET['action'])) {
            // For accept action
            $order_id = $_GET['order_id'];
            if ($_GET['action'] === 'accept') {
                $result = $order->updateOrderStatus($order_id, 'accepted');
                if ($result) {
                    redirect('orders');
                }
            }
        }

        

        // If we get here, something went wrong
        redirect('orders');
    }
}