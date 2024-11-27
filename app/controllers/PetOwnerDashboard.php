<?php
class PetOwnerDashboard {
    use Controller;

    public function index() {
        $pet = new Pet();

        // Get all pets
        $pets = $pet->findAll();

        // Prepare data for the view
        $data = [
            'pets' => $pets,
            'petowner' => true, // Example for sidebar rendering logic
        ];

        // Pass the data array to the view
        $this->view('petownerdashboard', $data); // Pass $data instead of $pets
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
