<?php

class Orders
{
    use Controller;

    public function index()
    {
        $order = new Order();
        $pharmacy_id = 1; // For testing, we'll use pharmacy_id = 1

        $data = [
            'recent_orders' => $order->getRecentOrders($pharmacy_id),
            'order_stats' => $order->getOrderStats($pharmacy_id)
        ];

        $this->view('orders', $data);
    }

    public function updateStatus()
    {
        $order = new Order();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // For decline action
            $order_id = $_POST['order_id'];
            $reason = $_POST['decline_reason'];
            $notes = $_POST['notes'];
            
            $order->updateOrderStatus($order_id, 'declined', $reason, $notes);
        }
        else if(isset($_GET['order_id']) && isset($_GET['action']))
        {
            // For accept action
            $order_id = $_GET['order_id'];
            if($_GET['action'] === 'accept')
            {
                $order->updateOrderStatus($order_id, 'accepted');
            }
        }

        redirect('orders');
    }
}