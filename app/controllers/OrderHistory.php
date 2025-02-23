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
}