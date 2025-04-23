<?php

class PharmacyDashboard
{
    use Controller;

    public function index()
    {
        // Get pharmacy name using the pharmacy_id from session
        $pharmacyModel = new PharmacyModel();
        $pharmacy = $pharmacyModel->first(['pharmacy_id' => $_SESSION['pharmacy_id']]);
        
        // Get order statistics
        $order = new Order();
        $orderStats = $order->getOrderStats($_SESSION['pharmacy_id']);
        
        // Get total revenue from paid orders
        $revenue = new RevenueModel();
        $revenueStats = $revenue->getRevenueSummary($_SESSION['pharmacy_id']);
        
        $data = [
            'pharmacy_name' => $pharmacy->name ?? 'Pharmacy',
            'pending_orders' => $orderStats->pending_orders ?? 0,
            'total_revenue' => $revenueStats['total_revenue'] ?? 0
        ];
        
        $this->view('pharmacydashboard', $data);
    }
}



