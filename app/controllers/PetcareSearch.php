<?php

class PetcareSearch
{
    use Controller;
    private $petCareModel;

    public function __construct()
    {
        $this->petCareModel = $this->loadModel('PetCare');
    }

    public function index()
    {
        error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST Data: " . print_r($_POST, true));
        $petCareCenters = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['clear'])) {
                $petCareCenters = $this->petCareModel->getAllCenters();
            } 
            elseif (isset($_POST['search'])) {
                $name = trim($_POST['name'] ?? '');
                $location = trim($_POST['location'] ?? '');
                $petCareCenters = $this->petCareModel->searchCenters($name, $location);
            }
        } else {
            // Default: show all pet care centers
            $petCareCenters = $this->petCareModel->getAllCenters();
        }

        // Format the data for display
        $formattedCenters = [];
        foreach ($petCareCenters as $center) {
            $formattedCenters[] = [
                'name' => $center->name,
                'district' => $center->district,
                'city' => $center->city,
                'street' => $center->street,
                'contact_number' => $center->contact_no,
                'rating' => 4.5,
                'services' => 'Pet Care Services',
            ];
        }

        // Load the view with data
        $this->view('petcaresearch', [
            'petCareCenters' => $formattedCenters
        ]);
    }
}
