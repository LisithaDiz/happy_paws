<?php
        

class CareCenter
{        

    use Controller;

    public function index()
    {
        // Redirect to the cage management page by default
        redirect('/care-center/cages');
    }

    public function addCage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the care center ID from the session
            $care_center_id = $_SESSION['care_center_id']?? null;
            
            if (!$care_center_id) {
                $_SESSION['error'] = "You must be logged in as a care center to add cages";
                redirect('/care-center/cages');
                return;
            }

            // Create new CageModel instance
            $cageModel = new CageModel();

            // Prepare the cage data
            $cageData = [
                'care_center_id' => $care_center_id,
                'cage_name' => $_POST['cage_name'] ?? '',
                'number_of_cages' => $_POST['number_of_cages'] ?? 0,
                'height' => $_POST['height'] ?? 0,
                'length' => $_POST['length'] ?? 0,
                'width' => $_POST['width'] ?? 0,
                'designed_for' => $_POST['designed_for'] ?? '',
                'location' => $_POST['location'] ?? '',
                'additional_features' => $_POST['additional_features'] ?? '',
                'available_cages' => $_POST['available_cages'] ?? 0
            ];

            // Handle image upload if provided
            if (isset($_FILES['cage_img']) && $_FILES['cage_img']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = ROOT . '/assets/images/cages/';
                $fileName = uniqid() . '_' . basename($_FILES['cage_img']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['cage_img']['tmp_name'], $targetPath)) {
                    $cageData['cage_img'] = $fileName;
                }
            }

            // Insert the cage
            $result = $cageModel->insertCage($cageData);

            if ($result['status'] === 'success') {
                $_SESSION['success'] = $result['message'];
            } else {
                $_SESSION['error'] = $result['message'];
            }

            // Redirect back to the cage management page
            redirect('/careCenterCage');
        } else {
            // If not a POST request, redirect to the cage management page
            redirect('/careCenterCage');
        }
    }

    

    
}


