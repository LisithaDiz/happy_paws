<?php

class CareCenterCage
{
    use Controller;

    public function index()
    {   
        $center_id=$_SESSION['care_center_id'];
        $manageCageController = new cageModel();
		$cage =$manageCageController->getAllCages($center_id); 
		// var_dump($cage);

		$data =['cages' => $cage];
        $this->view('carecentercage',$data);
    }

    public function deleteCage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cage_id = $_POST['cage_id'];
            $manageCageController = new cageModel();
            $result = $manageCageController->deleteCage($cage_id);
            
            if ($result) {
                $_SESSION['message'] = "Cage deleted successfully";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to delete cage";
                $_SESSION['message_type'] = "error";
            }
            
            redirect('careCenterCage');
        }
    }
    public function updateCage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the care center ID from the session
            $care_center_id = $_SESSION['care_center_id'] ?? null;
            
            if (!$care_center_id) {
                $_SESSION['error'] = "You must be logged in as a care center to update cages";
                redirect('/login');
                return;
            }

            // Create new CageModel instance
            $cageModel = new CageModel();

            // Prepare the cage data
            $cageData = [
                'id' => $_POST['cage_id'] ?? null,
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

            // Update the cage
            $result = $cageModel->updateCage($cageData['id'],$cageData,'cage_id');

            if ($result['status'] === 'success') {
                $_SESSION['success'] = $result['message'];
            } else {
                $_SESSION['error'] = $result['message'];
            }

            // Redirect back to the cage management page
            redirect('/careCenterCage');
        } else {
            // If not a POST request, redirect to the cage management page
            redirect('careCenterCage');
        }
    }
}