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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $sitter_id = $_SESSION['sitter_id'] ?? null;
                $date = $_POST['date'] ?? null;
                $slots = $_POST['slots'] ?? null;
                $price = $_POST['price'] ?? null;

                // Log the received data
                error_log("Received update request:");
                error_log("Sitter ID: " . $sitter_id);
                error_log("Date: " . $date);
                error_log("Slots: " . $slots);
                error_log("Price: " . $price);
                error_log("POST data: " . print_r($_POST, true));

                if (!$sitter_id || !$date || !$slots || !$price) {
                    error_log("Missing required parameters");
                    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                    return;
                }

                // Validate date format (YYYY-MM-DD)
                $dateParts = explode('-', $date);
                if (count($dateParts) !== 3 || 
                    !checkdate($dateParts[1], $dateParts[2], $dateParts[0])) {
                    error_log("Invalid date format: " . $date);
                    echo json_encode(['success' => false, 'message' => 'Invalid date format']);
                    return;
                }

                // Validate slots
                if (!is_numeric($slots) || $slots < 1 || $slots > 10) {
                    error_log("Invalid slots value: " . $slots);
                    echo json_encode(['success' => false, 'message' => 'Invalid number of slots']);
                    return;
                }

                // Validate price
                if (!is_numeric($price) || $price < 0) {
                    error_log("Invalid price value: " . $price);
                    echo json_encode(['success' => false, 'message' => 'Invalid price']);
                    return;
                }

                // Update or insert availability
                $result = $this->sitterAvailability->updateAvailability($sitter_id, $date, $slots, $price);

                if ($result) {
                    error_log("Availability update successful");
                    echo json_encode(['success' => true, 'message' => 'Availability updated successfully']);
                } else {
                    error_log("Availability update failed");
                    echo json_encode(['success' => false, 'message' => 'Failed to update availability']);
                }
            } catch (Exception $e) {
                error_log("Error in updateAvailability: " . $e->getMessage());
                error_log("Stack trace: " . $e->getTraceAsString());
                echo json_encode(['success' => false, 'message' => 'An error occurred while updating availability']);
            }
        } else {
            error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
    }
} 