<?php

class Revenue
{
    use Controller;

    public function index()
    {
        // Check if user is logged in and is a pharmacy
        if (!isset($_SESSION['pharmacy_id'])) {
            redirect('login');
        }

        $revenue = new RevenueModel();
        
        // Ensure monthly revenue table exists
        $revenue->createMonthlyRevenueTable();
        
        // Update monthly revenue data
        $revenue->updateMonthlyRevenue($_SESSION['pharmacy_id']);
        
        // Get all revenue data
        $data = [
            'summary' => $revenue->getRevenueSummary($_SESSION['pharmacy_id']),
            'monthly_revenue' => $revenue->getMonthlyRevenueDetails($_SESSION['pharmacy_id'])
        ];
        
        $this->view('revenue', ['data' => $data]);
    }
}