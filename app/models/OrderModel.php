<?php 

class OrderModel {
    private $db;
    use Database;
    public function __construct() {
        // $this->db = new Database;
    }
    //creates a new order
    public function createOrder($data) {
        $this->query('INSERT INTO orders (order_ID, medicine_type, owner_ID, pharmacy_ID, prescription, status) 
                     VALUES (:order_ID, :medicine_type, :owner_ID, :pharmacy_ID, :prescription, "pending")',
                     [
                         ':order_ID' => $this->getNextOrderID(),
                         ':medicine_type' => $data['medicine_type'],
                         ':owner_ID' => $data['owner_ID'],
                         ':pharmacy_ID' => $data['pharmacy_ID'],
                         ':prescription' => $data['prescription']
                     ]);
    }
    
    //gets the next order ID
    private function getNextOrderID() {
        $this->db->query('SELECT MAX(order_ID) as max_id FROM orders');
        $result = $this->db->single();
        return ($result->max_id ?? 0) + 1;
    }

    //gets the orders for a pharmacy
    public function getPharmacyOrders($pharmacy_ID) {
        return $this->query('SELECT o.*, po.f_name as owner_name 
                    FROM orders o 
                    JOIN pet_owner po ON o.owner_ID = po.owner_ID 
                    WHERE o.pharmacy_ID = :pharmacy_ID',
                    [':pharmacy_ID' => $pharmacy_ID]);
    }

    //gets the orders for a user
    public function getUserOrders($owner_ID) {
        return $this->query('SELECT o.*, p.name as pharmacy_name 
                         FROM orders o 
                         JOIN pharmacy p ON o.pharmacy_ID = p.pharmacy_ID 
                         WHERE o.owner_ID = :owner_ID',
                         [':owner_ID' => $owner_ID]);
    }

    public function updateStatus($order_ID, $medicine_type, $status) {
        $this->db->query('UPDATE orders SET status = :status 
                         WHERE order_ID = :order_ID AND medicine_type = :medicine_type');
        $this->db->bind(':status', $status);
        $this->db->bind(':order_ID', $order_ID);
        $this->db->bind(':medicine_type', $medicine_type);
        return $this->db->execute();
    }
}