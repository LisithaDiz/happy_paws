<?php

class VetSearch
{
    use Controller;

    public function index()
    {
        // Dummy data for veterinarians
        $allVets = [
            [
                "name" => "Dr. John Doe",
                "location" => "New York",
                "rating" => 4,
                "specialties" => "Dogs, Cats, Birds",
                "image_url" => "default-vet.jpg"
            ],
            [
                "name" => "Dr. Jane Smith",
                "location" => "Los Angeles",
                "rating" => 5,
                "specialties" => "Dogs, Cats, Reptiles",
                "image_url" => "default-vet.jpg"
            ],
            [
                "name" => "Dr. Emily White",
                "location" => "Chicago",
                "rating" => 3,
                "specialties" => "Dogs, Cats, Exotic Pets",
                "image_url" => "default-vet.jpg"
            ],
            [
                "name" => "Dr. Michael Brown",
                "location" => "Boston",
                "rating" => 5,
                "specialties" => "Dogs, Cats, Small Animals",
                "image_url" => "default-vet.jpg"
            ],
            [
                "name" => "Dr. Sarah Johnson",
                "location" => "San Francisco",
                "rating" => 4,
                "specialties" => "Cats, Birds, Small Animals",
                "image_url" => "default-vet.jpg"
            ]
        ];

        // Default vets to display
        $vets = $allVets;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['clear'])) {
                // Reset to show all vets
                $vets = $allVets;
            } 
            elseif (isset($_POST['search'])) {
                $searchName = strtolower(trim($_POST['name'] ?? ''));
                $searchLocation = strtolower(trim($_POST['location'] ?? ''));

                // Filter vets based on search criteria
                $vets = array_filter($allVets, function ($vet) use ($searchName, $searchLocation) {
                    $nameMatch = empty($searchName) || str_contains(strtolower($vet['name']), $searchName);
                    $locationMatch = empty($searchLocation) || str_contains(strtolower($vet['location']), $searchLocation);
                    return $nameMatch && $locationMatch;
                });

                // If no results found, set empty array
                if (empty($vets)) {
                    $vets = [];
                }
            }
        }

        // Pass vets to the view
        $this->view('vetsearch', ['vets' => $vets]);
    }
}
