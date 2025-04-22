<?php

class PetDetails
{
    use Controller;

    public function index()
    {
        // Fetch pet details
        $petModel = new Pet(); // Assuming the Pet class is properly set up
        $owner_id = $_GET['owner_id'] ?? null; // Get owner_id from the request
        $pet_id = $_GET['pet_id'] ?? null;     // Get pet_id from the request

        // Ensure both owner_id and pet_id are set
        if ($owner_id && $pet_id) {
            $pet = $petModel->findByOwnerAndPet($owner_id, $pet_id); // Use the function defined earlier
        } else {
            $pet = null; // No data if IDs are not provided
        }

        // Pass the pet data to the view
        $this->view('petdetails', ['pet' => $pet ?: '']);
    }

    public function deletePet()
    {
        // Handle deletion of pet
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pet_id = $_POST['pet_id'] ?? null;

            if ($pet_id) {
                $petModel = new Pet(); // Assuming the Pet class exists
                $petModel->deletePet($pet_id); // Assuming a `delete` method exists in the Pet class
                // Redirect to a success page or back to the pet list
                redirect("PetOwnerDash");
                exit;
            } else {
                // Handle error when pet_id is not provided
                echo "Pet ID is required for deletion.";
            }
        }
    }

    public function createPet() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input data
            $data = [
                'owner_id' => $_POST['owner_id'] ?? null,
                'pet_name' => trim($_POST['pet_name'] ?? ''),
                'pet_type' => trim($_POST['pet_type'] ?? ''),
                'breed' => trim($_POST['breed'] ?? ''),
                'age' => (int)($_POST['age'] ?? 0),
                'color' => trim($_POST['color'] ?? ''),
                'weight' => (float)($_POST['weight'] ?? 0),
                'vaccinations' => trim($_POST['vaccinations'] ?? ''),
                'date_of_birth' => $_POST['date_of_birth'] ?? null,
            ];
    
            // Validate required fields
            if (empty($data['owner_id']) || empty($data['pet_name']) || empty($data['pet_type'])) {
                header('Location: ' . ROOT . '/petownerdash?error=missing_required_fields');
                exit;
            }
    
            try {
                $pet = new Pet();
    
                // Insert the new pet
                if ($pet->insert($data)) {
                    header('Location: ' . ROOT . '/petownerdash?success=pet_created');
                } else {
                    header('Location: ' . ROOT . '/petownerdash?error=create_failed');
                }
            } catch (Exception $e) {
                error_log("Error creating pet: " . $e->getMessage());
                header('Location: ' . ROOT . '/petownerdash?error=create_failed');
            }
    
            exit;
        }
    
        // Render the create pet form (GET request)
        $this->view('createPet');
    }
    
}

?>
