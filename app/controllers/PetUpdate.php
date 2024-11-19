<?php

class PetUpdate
{
    use Controller;

    public function index($pet_id = null, $owner_id = null)
    {
        // If $pet_id or $owner_id is not provided, check if it's available in GET
        if (!$pet_id || !$owner_id) {
            $pet_id = $_GET['pet_id'] ?? null;
            $owner_id = $_GET['owner_id'] ?? null;
        }
    
        // Check if pet_id and owner_id are still missing
        if (!$pet_id || !$owner_id) {
            echo "Pet ID or Owner ID is missing.";
            return;
        }
    
        // Fetch pet details
        $petModel = new Pet();
        $pet = $petModel->findByOwnerAndPet($owner_id, $pet_id);
    
        if (!$pet) {
            echo "Pet not found!";
            return;
        }
    
        // Render the view
        $this->view('petupdate', ['pet' => $pet]);
    }

    // This method should be called when the form is submitted
    public function updatePetDetails($pet_id = null, $owner_id = null)
{
    // If pet_id and owner_id are not passed via POST, try GET
    if (!$pet_id || !$owner_id) {
        // Check for query parameters in the URL
        $pet_id = $_GET['pet_id'] ?? $pet_id;
        $owner_id = $_GET['owner_id'] ?? $owner_id;
    }

    // Debugging: Check if pet_id and owner_id are set
    echo "Pet ID: $pet_id, Owner ID: $owner_id";  // Check if they are properly populated

    // Check if pet_id and owner_id are missing
    if (!$pet_id || !$owner_id) {
        echo "Pet ID or Owner ID is missing!";
        return;
    }

    // Get the form data from the POST request
    $data = [
        'pet_name'     => $_POST['pet_name'] ?? '',
        'pet_type'     => $_POST['pet_type'] ?? '',
        'breed'        => $_POST['breed'] ?? '',
        'age'          => $_POST['age'] ?? '',
        'color'        => $_POST['color'] ?? '',
        'weight'       => $_POST['weight'] ?? '',
        'vaccinations' => $_POST['vaccinations'] ?? '',
        'date_of_birth'=> $_POST['date_of_birth'] ?? ''
    ];

    // Directly instantiate the Pet model
    $petModel = new Pet();

    // Call the update method
    $result = $petModel->updatePet($pet_id, $data);

    // Handle the result (e.g., redirect, show a success message, etc.)
    if ($result) {
        echo "Pet details updated successfully!";
        // Optionally, redirect to another page
        // header("Location: /somepage");
    } else {
        echo "Error updating pet details.";
    }

    return $result;
}

}
