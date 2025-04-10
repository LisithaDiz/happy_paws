<?php

class PharmacyDashboard
{
    use Controller;

    public function index()
    {
        // Get pharmacy name using the pharmacy_id from session
        $pharmacyModel = new PharmacyModel();
        $pharmacy = $pharmacyModel->first(['pharmacy_id' => $_SESSION['pharmacy_id']]);
        
        $data = [
            'pharmacy_name' => $pharmacy->name ?? 'Pharmacy'
        ];
        
        $this->view('pharmacydashboard', $data);
    }
}



