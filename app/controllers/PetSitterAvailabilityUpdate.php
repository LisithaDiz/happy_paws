<?php

class PetSitterAvailabilityUpdate
{
    use Controller;

    private $sitterAvailability;

    public function __construct()
    {
        $this->sitterAvailability = new SitterAvailability();
    }

    public function index()
    {
        // Get the sitter_id from session
        $sitter_id = $_SESSION['sitter_id'] ?? null;
        
        if (!$sitter_id) {
            redirect('login');
        }

        // Get current availability data
        $availabilityData = $this->sitterAvailability->getSitterAvailability($sitter_id);
        
        // Log the data for debugging
        error_log("Loading availability data for sitter: $sitter_id");
        error_log("Availability data: " . print_r($availabilityData, true));

        $this->view('petsitteravailabilityupdate', [
            'availabilityData' => $availabilityData
        ]);
    }

    public function updateAvailability()
{
    // Turn off PHP error output to prevent HTML error messages in the response
    ini_set('display_errors', 0);
    
    // Set content type to JSON
    header('Content-Type: application/json');
    
    try {
        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        // Get the sitter_id from session
        $sitter_id = $_SESSION['sitter_id'] ?? null;
        
        if (!$sitter_id) {
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            return;
        }

        // Get form data
        $date = $_POST['date'] ?? '';
        $slots = $_POST['slots'] ?? '';
        $price = $_POST['price'] ?? '';

        // Validate the data
        if (empty($date) || empty($slots) || !is_numeric($slots) || $slots <= 0 || empty($price) || !is_numeric($price) || $price < 0) {
            echo json_encode(['success' => false, 'message' => 'Please provide valid values for all fields']);
            return;
        }

        // Debug log
        error_log("Updating availability: sitter_id=$sitter_id, date=$date, slots=$slots, price=$price");

        // Check if this date already has an entry
        $existingAvailability = $this->sitterAvailability->first(['sitter_id' => $sitter_id, 'day' => $date]);
        
        $result = false;

        if ($existingAvailability) {
            // Update existing record
            error_log("Updating existing record: avl_id=" . $existingAvailability->avl_id);
            $result = $this->sitterAvailability->update(
                $existingAvailability->avl_id, 
                [
                    'number_of_slots' => $slots,
                    'price_per_slot' => $price
                ],
                'avl_id'
            );
        } else {
            // Insert new record
            error_log("Inserting new record");
            $result = $this->sitterAvailability->insert([
                'sitter_id' => $sitter_id,
                'day' => $date,
                'number_of_slots' => $slots,
                'price_per_slot' => $price
            ]);
        }

        error_log("Result of operation: " . ($result ? "success" : "failure"));

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Availability updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update availability']);
        }
    } catch (Exception $e) {
        // Log the exception but return a clean JSON error
        error_log("Exception in updateAvailability: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred while updating availability']);
    }
    
    // Make sure to exit to prevent any additional output
    exit;
}

} 