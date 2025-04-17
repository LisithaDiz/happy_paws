<?php

class VetAvailableHours
{
    use Controller;

    public function index()
    {
        $vetAvailableHoursModel = new VetUpdateAvailableHoursModel;
        $currentAvailabilityDetails = $vetAvailableHoursModel->vetAvailabilityVetView();

        $this->view('VetAvailableHours',['currentAvailabilityDetails' => $currentAvailabilityDetails]);
    }

  
    // public function availableHours()
    // {

        
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         // Get the form data from the POST request
    //         $data = [
    //             'day_of_week'                   => $_POST['day_of_week'],
    //             'start_time'                    => $_POST['start_time'],
    //             'end_time'                      => $_POST['end_time'],
    //             'number_of_appointments'        => $_POST['number_of_appointments'],
                
    //         ];

    //         $userid = $_SESSION['user_id'];
            
           
    //         // var_dump($userid);

    //         $vetUpdateAvailabilityModel = new VetUpdateAvailableHoursModel(); // Use VetModel which extends the core Model

    //         // After updating, you can redirect the user to the profile page or show a success message
    //         $result = $vetUpdateAvailabilityModel-> insertAvailableHours($userid,$data);
            
            

    //         return $result;
            
            
    //         }
    //         return false;
    // }
    

    public function removeSlot()
    {
        $slotId = $_POST['slot_id'];
        $vetUpdateAvailabilityModel = new VetUpdateAvailableHoursModel();
    
        // Step 1: Check for appointments on or after today for the given slot
        $query = "SELECT * FROM appointment 
                  WHERE avl_id = :slotId 
                  AND appointment_date >= CURDATE()";
    
        $appointments = $vetUpdateAvailabilityModel->query($query, ['slotId' => $slotId]);
    
        if ($appointments && is_array($appointments) && count($appointments) > 0) {
            // Appointments found — show alert
            echo "<script>
                    alert('Cannot delete this slot! There are upcoming appointments scheduled.');
                    window.location.href = '" . ROOT . "/vetavailablehours';
                 </script>";
            exit;
        } else {
            // No future appointments — safe to delete
            $deleteQuery = "DELETE FROM vet_availability WHERE avl_id = :slotId";
            $result = $vetUpdateAvailabilityModel->query($deleteQuery, ['slotId' => $slotId]);
    
            if ($result) {
                echo "<script>
                        alert('Slot successfully deleted.');
                        window.location.href = '" . ROOT . "/vetavailablehours';
                     </script>";
            } else {
                echo "<script>
                        alert('Error deleting the slot. Please try again.');
                        window.location.href = '" . ROOT . "/vetavailablehours';
                     </script>";
            }
            exit;
        }
    }
    

    

  
}

