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

        // Initialize with default pet care centers
        // $petCareCenters = [
        //     [
        //         'name' => 'Happy Paws Care Center',
        //         'location' => 'Colombo',
        //         'rating' => 4.5,
        //         'services' => 'Grooming, Boarding, Training',
        //         'image' => 'default-petcare.jpg'
        //     ],
        //     [
        //         'name' => 'Pawsome Care',
        //         'location' => 'Kandy',
        //         'rating' => 4.0,
        //         'services' => 'Boarding, Day Care, Training',
        //         'image' => 'default-petcare.jpg'
        //     ],
        //     [
        //         'name' => 'Pet Paradise',
        //         'location' => 'Galle',
        //         'rating' => 4.8,
        //         'services' => 'Grooming, Boarding, Pet Hotel',
        //         'image' => 'default-petcare.jpg'
        //     ],
        //     // Add more dummy data as needed
        // ];
        $careCenterController = new CareCenterModel(); 
        $petCareCenters = $careCenterController->getSearchInfo();
        // var_dump($petCareCenters);

        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     if (isset($_POST['clear'])) {
        //         $petCareCenters = $careCenterController->getSearchInfo();
        //     } 
        //     elseif (isset($_POST['search'])) {
        //         $name = trim($_POST['name'] ?? '');
        //         $location = trim($_POST['location'] ?? '');
        //         $petCareCenters = $this->petCareModel->searchCenters($name, $location);
        //     }
        // } else {
        //     // Default: show all pet care centers
        //     $petCareCenters = $this->petCareModel->getAllCenters();
        // }

        // Format the data for display
        // $formattedCenters = [];
        // foreach ($petCareCenters as $center) {
        //     $formattedCenters[] = [
        //         'name' => $center->name,
        //         'district' => $center->district,
        //         'city' => $center->city,
        //         'street' => $center->street,
        //         'contact_number' => $center->contact_no,
        //         'rating' => 4.5,
        //         'services' => 'Pet Care Services',
        //     ];
        // }

        // Load the view with data
        $this->view('petcaresearch', [
            'petCareCenters' => $petCareCenters
        ]);
    }
}
