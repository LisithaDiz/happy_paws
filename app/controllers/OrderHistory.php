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

    public function updatePaymentStatus($order_id)
    {
        $order = new Order();
        $result = $order->updatePaymentStatus($order_id, 'paid');
        
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}