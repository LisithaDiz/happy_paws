<?php

class PharmSearch
{
    use Controller;
    private $pharmacyModel;

    public function __construct()
    {
        $this->pharmacyModel = $this->loadModel('PharmacyModel');
    }

    public function index()
    {
        $pharmacies = [];
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['clear'])) {
                $pharmacies = $this->pharmacyModel->getPharmacy();
            } 
            elseif (isset($_POST['search'])) {
                $name = trim($_POST['name'] ?? '');
                $location = trim($_POST['location'] ?? '');
                $pharmacies = $this->pharmacyModel->searchPharmacy($name, $location);
            }
        } else {
            // Default: show all pharmacys
            $pharmacies = $this->pharmacyModel->getPharmacy();
        }

        // Ensure $pharmacies is an array before using it in foreach
        if (!is_array($pharmacies)) {
            $pharmacies = []; // Default to an empty array if not valid
        }

        // Format the data for display
        $formattedPharmacies = [];
        foreach ($pharmacies as $pharmacy) {
            $formattedPharmacies[] = [
                'pharmacy_id' => $pharmacy->pharmacy_id,
                'name' => $pharmacy->name,
                'location' => $pharmacy->location,
                'rating' => 4.5, // You can add a ratings table later
                'image' => 'default-petpharmacy.jpg',
                'contact_no' => $pharmacy->contact_no,
                'services' => 'Pet medication and petfood',
                'description' => 'We are providing all the medication products needed for your pets. We have wide range of medicines.' 
            ];
        }

        // Load the view with data
        $this->view('pharmsearch', [
            'pharmacies' => $formattedPharmacies
        ]);
    }
}