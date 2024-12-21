<?php

class VetSearch
{
    use Controller;
    private $vetModel;

    public function __construct()
    {
        $this->vetModel = $this->loadModel('Vet');
    }

    public function index()
    {
        error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST Data: " . print_r($_POST, true));
        $vets = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['clear'])) {
                $vets = $this->vetModel->getAllVets();
            } 
            elseif (isset($_POST['search'])) {
                $name = trim($_POST['name'] ?? '');
                $location = trim($_POST['location'] ?? '');
                $vets = $this->vetModel->searchVets($name, $location);
            }
        } else {
            // Default: show all vets
            $vets = $this->vetModel->getAllVets();
        }

        // Format the data for display
        $formattedVets = [];
        foreach ($vets as $vet) {
            $avgRating = $this->vetModel->getAverageRating($vet->vet_id);
            $formattedVets[] = [
                'vet_id' => $vet->vet_id,
                'name' => htmlspecialchars($vet->name),
                'location' => htmlspecialchars($vet->location),
                'street' => htmlspecialchars($vet->street),
                'experience' => htmlspecialchars($vet->experience),
                'contact_no' => htmlspecialchars($vet->contact_no),
                'rating' => $avgRating
            ];
        }

        // Load the view with data
        $this->view('vetsearch', [
            'vets' => $formattedVets
        ]);
    }
}
