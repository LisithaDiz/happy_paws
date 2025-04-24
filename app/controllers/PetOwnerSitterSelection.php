<?php
// Enable error reporting

class PetOwnerSitterSelection
{
    use Controller;

    public function index()
    {
        $sitter_id = $_GET['sitter_id'] ?? null;
        
        if (!$sitter_id) {
            // Handle error - no sitter selected
            redirect('PetsitterSearch');
        }

        // Fetch sitter availability data
        $sitterAvailability = new SitterAvailability();
        $availabilityData = $sitterAvailability->getSitterAvailability($sitter_id);

        // Fetch pet owner's pets
        $petModel = new Pet();
        $owner_id = $_SESSION['owner_id'] ?? null;
        $pets = [];
        
        if ($owner_id) {
            $pets = $petModel->findAllByOwnerId($owner_id);
        }

        $data = [
            'sitter_id' => $sitter_id,
            'availabilityData' => $availabilityData,
            'pets' => $pets
        ];

        $this->view('petownersitterselection', $data);
    }

    public function placeOrder()
    {
        // Log the incoming GET parameters
        error_log("Received GET parameters: " . print_r($_GET, true));
        
        $sitter_id = $_GET['sitter_id'] ?? null;
        $pet_id = $_GET['pet_id'] ?? null;
        $dates = $_GET['dates'] ?? null;
    
        if (!$sitter_id || !$pet_id || !$dates) {
            error_log("Missing required data: sitter_id=" . $sitter_id . ", pet_id=" . $pet_id . ", dates=" . $dates);
            $_SESSION['error'] = "Missing required data for booking.";
            redirect('PetOwnerSitterSelection/index?sitter_id=' . $sitter_id);
            return;
        }
    
        $datesArray = explode(',', $dates);
        error_log("Dates array: " . print_r($datesArray, true));
        
        $appointmentsModel = new SitterAppointments();
        $success = true;
        
        foreach ($datesArray as $date) {
            $appointmentData = [
                'pet_id' => $pet_id,
                'sitter_id' => $sitter_id,
                'day_of_appointment' => $date,
                'appointment_status' => 'pending'
            ];
            
            error_log("Attempting to insert appointment data: " . print_r($appointmentData, true));
            
            $result = $appointmentsModel->insert($appointmentData);
            
            if (!$result) {
                $success = false;
                error_log("Failed to insert appointment for date: " . $date);
            } else {
                error_log("Successfully inserted appointment for date: " . $date);
            }
        }
    
        if ($success) {
            $_SESSION['success'] = "Appointments booked successfully!";
        } else {
            $_SESSION['error'] = "Some appointments could not be booked. Please try again.";
        }
        
        redirect('PetsitterSearch');
    }
    
}