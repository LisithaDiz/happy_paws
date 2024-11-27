<?php

class Petcaresearch
{
    use Controller;

    public function index()
    {
        // Initialize with default pet care centers
        $petCareCenters = [
            [
                'name' => 'Happy Paws Care Center',
                'location' => 'Colombo',
                'rating' => 4.5,
                'services' => 'Grooming, Boarding, Training',
                'image' => 'default-petcare.jpg'
            ],
            [
                'name' => 'Pawsome Care',
                'location' => 'Kandy',
                'rating' => 4.0,
                'services' => 'Boarding, Day Care, Training',
                'image' => 'default-petcare.jpg'
            ],
            [
                'name' => 'Pet Paradise',
                'location' => 'Galle',
                'rating' => 4.8,
                'services' => 'Grooming, Boarding, Pet Hotel',
                'image' => 'default-petcare.jpg'
            ],
            // Add more dummy data as needed
        ];

        // Handle search functionality
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['clear'])) {
                // Keep the default results when clearing
            } 
            elseif (isset($_POST['search'])) {
                $name = strtolower(trim($_POST['name'] ?? ''));
                $location = strtolower(trim($_POST['location'] ?? ''));

                // Filter results based on search criteria
                $petCareCenters = array_filter($petCareCenters, function($center) use ($name, $location) {
                    $nameMatch = empty($name) || str_contains(strtolower($center['name']), $name);
                    $locationMatch = empty($location) || str_contains(strtolower($center['location']), $location);
                    return $nameMatch && $locationMatch;
                });
            }
        }

        // Load the view with data
        $this->view('petcaresearch', [
            'petCareCenters' => $petCareCenters
        ]);
    }
}
