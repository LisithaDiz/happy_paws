<?php

class Orders
{
    use Controller;

    public function index()
    {
        $orders_data = [
            'pending_orders' => [
                [
                    'order_id' => 'ORD-001',
                    'customer_name' => 'John Smith',
                    'pet_name' => 'Max',
                    'pet_type' => 'Dog',
                    'medicine' => 'Heartworm Prevention',
                    'quantity' => 2,
                    'total_price' => 45.99,
                    'order_date' => '2024-03-15',
                    'status' => 'pending'
                ],
                [
                    'order_id' => 'ORD-002',
                    'customer_name' => 'Sarah Johnson',
                    'pet_name' => 'Luna',
                    'pet_type' => 'Cat',
                    'medicine' => 'Flea Treatment',
                    'quantity' => 1,
                    'total_price' => 29.99,
                    'order_date' => '2024-03-15',
                    'status' => 'pending'
                ],
            ],
            'processed_orders' => [
                [
                    'order_id' => 'ORD-003',
                    'customer_name' => 'Mike Wilson',
                    'pet_name' => 'Rocky',
                    'pet_type' => 'Dog',
                    'medicine' => 'Joint Supplement',
                    'quantity' => 3,
                    'total_price' => 65.50,
                    'order_date' => '2024-03-14',
                    'status' => 'accepted',
                    'processed_date' => '2024-03-14'
                ],
                [
                    'order_id' => 'ORD-004',
                    'customer_name' => 'Emily Brown',
                    'pet_name' => 'Milo',
                    'pet_type' => 'Cat',
                    'medicine' => 'Antibiotics',
                    'quantity' => 1,
                    'total_price' => 35.00,
                    'order_date' => '2024-03-13',
                    'status' => 'declined',
                    'processed_date' => '2024-03-13',
                    'decline_reason' => 'Out of stock'
                ],
            ]
        ];

        $this->view('orders', [
            'data' => $orders_data
        ]);
    }

    public function updateStatus()
    {
        // In a real application, this would update the database
        // For now, we'll just redirect back to the orders page
        header("Location: " . ROOT . "/orders");
        exit();
    }
}