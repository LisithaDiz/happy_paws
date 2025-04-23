<?php

class CareCenterProfile
{
    use Controller;

    public function index()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
            return;
        }

        // Check if user has proper role (4 for care center staff)
        if ($_SESSION['user_role'] != 4) {
            // If not care center staff, check if they're a pet owner
            if (!isset($_SESSION['owner_id'])) {
                redirect('home');
                return;
            }
        }

        if (isset($_SESSION['owner_id'])) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo "<script>
                        alert('Something went wrong!');
                        window.location.href = 'PetcareSearch';
                      </script>";
                exit();
            }
            $center_id = $_POST["id"];
        } else if (isset($_SESSION['care_center_id'])) {
            $center_id = $_SESSION['care_center_id'];
        } else {
            die('Error: Care center ID not found in session.');
        }

        // Get Care Center Info
        $careCenterModel = new CareCenterModel();
        $care_center = $careCenterModel->getCareCenterInfo($center_id);

        // Get All Cages
        $cageModel = new CageModel();
        $cages = $cageModel->getAllCages($center_id);

        // Only get pets if user is a pet owner
        $pets = [];
        if (isset($_SESSION['owner_id'])) {
            $pets = new Pet();
            $pets = $pets->findAllByOwnerId($_SESSION['owner_id']);
        }

        $data = [
            'pets' => $pets,
            'cages' => $cages,
            'petCareCenter' => $care_center
        ];
        // var_dump($data);

        $this->view('carecenterprofile', $data);
    }

    public function updateProfile() {
        if ($_SESSION['user_role'] != 4) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $careCenterModel = new CareCenterModel();
        $center_id = $_POST['care_center_id'];

        // Remove care_center_id from POST data as it's not needed in the update
        unset($_POST['care_center_id']);

        $result = $careCenterModel->updateProfile($_POST, $center_id);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
        }
    }
}
