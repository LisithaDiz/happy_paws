<?php
class PetOwnerDashboard {
    use Controller;
    public function index() {
        // Ensure the user is logged in and the session contains owner_id
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login if not logged in
            header('Location: /login');
            exit();
        }
    
        $owner_id = $_SESSION['owner_id']; // Assuming user_id is the owner_id
    
        $pet = new Pet();
    
        // Get all pets for the logged-in owner
        $pets = $pet->findAllByOwnerId($owner_id);
    
        // Prepare data for the view
        $data = [
            'pets' => $pets,
            'petowner' => true, // Example for sidebar rendering logic
        ];
    
        // Pass the data array to the view
        $this->view('petownerdashboard', $data);
    }
    
    public function deletePet() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pet_id = $_POST['pet_id'] ?? null;
    
            if (!$pet_id) {
                error_log("Pet ID not provided for deletion.");
                header('Location: /petownerdashboard?error=missing_pet_id');
                exit;
            }
    
            $pet = new Pet();
            if ($pet->delete($pet_id)) {
                header('Location: /petownerdashboard?success=pet_deleted');
            } else {
                header('Location: /petownerdashboard?error=delete_failed');
            }
            exit;
        }
    }
    
}


?>
