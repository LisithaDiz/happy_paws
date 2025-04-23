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

        // Ensure $petCareCenters is an array before using it in foreach
        if (!is_array($petCareCenters)) {
            $petCareCenters = []; // Default to an empty array if not valid
        }

        // Format the data for display
        $formattedCenters = [];
        foreach ($petCareCenters as $center) {
            // Check if $center is an object or an array
            $centerData = is_object($center) ? $center : (object)$center;
            
            // Get review data
            $care_center_id = $centerData->care_center_id ?? null;
            $rating = $care_center_id ? $this->petCareModel->getAverageRating($care_center_id) : 0;
            $review_count = $care_center_id ? $this->petCareModel->getReviewCount($care_center_id) : 0;
            
            $formattedCenters[] = [
                'care_center_id' => $care_center_id,
                'name' => $centerData->name ?? 'Unknown',
                'district' => $centerData->district ?? 'Not specified',
                'city' => $centerData->city ?? 'Not specified',
                'street' => $centerData->street ?? 'Not specified',
                'contact_no' => $centerData->contact_no ?? 'Not specified',
                'rating' => $rating,
                'review_count' => $review_count,
                'services_offered' => 'Pet Care Services', // Default services
                'profile_image' => null // No profile image by default
            ];
        }

        // Load the view with data
        $this->view('petcaresearch', [
            'petCareCenters' => $formattedCenters
        ]);
    }
}
