<?php

class PetsitterSearch
{
    use Controller;
    private $petSitterModel;

    public function __construct()
    {
        $this->petSitterModel = $this->loadModel('PetSitter');
    }

    public function index()
    {
        $petSitters = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['clear'])) {
                $petSitters = $this->petSitterModel->getAllSitters();
            } 
            elseif (isset($_POST['search'])) {
                $name = trim($_POST['name'] ?? '');
                $location = trim($_POST['location'] ?? '');
                $petSitters = $this->petSitterModel->searchSitters($name, $location);
            }
        } else {
            // Default: show all sitters
            $petSitters = $this->petSitterModel->getAllSitters();
        }

        // Ensure $petSitters is an array before using it in foreach
        if (!is_array($petSitters)) {
            $petSitters = []; // Default to an empty array if not valid
        }

        // Format the data for display
        $formattedSitters = [];
        foreach ($petSitters as $sitter) {
            $formattedSitters[] = [
                'sitter_id' => $sitter->sitter_id,
                'name' => $sitter->name,
                'location' => $sitter->location,
                'rating' => 4.5, // You can add a ratings table later
                'image' => 'default-petsitter.jpg',
                'description' => 'Professional pet sitter with ' . $sitter->experience . ' years of experience.',
                'experience' => $sitter->experience . ' years',
                'availability' => 'Weekdays & Weekends', // You can add this field to database later
                'price' => 'Rs. 1000/day', // You can add this field to database later
                'services' => 'Pet Sitting, Dog Walking, Pet Feeding', // You can add this field to database later
                'contact_no' => $sitter->contact_no
            ];
        }

        // Load the view with data
        $this->view('petsittersearch', [
            'petSitters' => $formattedSitters
        ]);
    }
}
