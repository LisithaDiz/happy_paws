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
                echo "<script>
                        alert('Medicine request sent successfully.');
                        window.location.href = '" . ROOT . "/vetMedRequest';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Medicine request failed to send.');
                      </script>";
            }
            
        } else {
            // If not a POST request, show an error or redirect
            echo "Invalid request method.";
        }
    }
}