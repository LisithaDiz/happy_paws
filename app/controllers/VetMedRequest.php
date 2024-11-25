<?php

class VetMedRequest
{
    use Controller;

    public function index()
    {
        $this->view('vetmedrequest');
    }

    public function addMedicineRequest()
    {
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the medicine name and note from the POST request
            $medicineName = $_POST['medicine_name'] ?? null;
            $note = $_POST['note'] ?? null;

            // Validate the input
            if (empty($medicineName)) {
                echo "Medicine name is required.";
                return;
            }

            $vetModel = new VetModel();

            // Add the medicine request to the database
            $result = $vetModel->addMedicineRequest($medicineName, $note);

            if ($result) {
                echo "Profile deleted successfully.";
                // Redirect after deletion
                header("Location: " . ROOT . "/vetmedrequest");
                exit();
            } else {
                echo "Failed to delete profile.";
            }
        } else {
            // If not a POST request, show an error or redirect
            echo "Invalid request method.";
        }
    }
}