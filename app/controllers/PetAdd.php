<?php

// PetAdd.php (Controller)
class PetAdd {
    use Controller;

    public function index() {
        $this->view('petadd');
    }

    public function createPet() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'owner_id' => $_POST['owner_id'] ?? '',
                'pet_name' => $_POST['pet_name'] ?? '',
                'pet_type' => $_POST['pet_type'] ?? '',
                'breed' => $_POST['breed'] ?? '',
                'age' => $_POST['age'] ?? '',
                'color' => $_POST['color'] ?? '',
                'weight' => $_POST['weight'] ?? '',
                'vaccinations' => $_POST['vaccinations'] ?? '',
                'date_of_birth' => $_POST['date_of_birth'] ?? '',
            ];

            // Validate form data
            $errors = [];
            foreach ($data as $key => $value) {
                if (empty($value) && $key !== 'breed') {
                    $errors[] = ucfirst(str_replace('_', ' ', $key)) . " is required.";
                }
            }

            if (!empty($errors)) {
                $this->view('petadd', ['errors' => $errors, 'data' => $data]);
                return;
            }

            $petModel = new Pet();
            if ($petModel->insertPet($data)) {
                header("Location: " . ROOT . "/petownerdash");
                exit;
            } else {
                $this->view('petadd', ['error' => 'Failed to add pet. Please try again.', 'data' => $data]);
            }
        }
    }
}
?>
