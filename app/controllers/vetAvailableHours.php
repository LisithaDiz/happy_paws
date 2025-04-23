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

    public function availableHours()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userid = $_SESSION['user_id']; 
        
        $userModel = new UserModel();
        $query = "SELECT vet_id FROM veterinary_surgeon WHERE user_id = :user_id";
        $vetResult = $userModel->query($query, ['user_id' => $userid]);
        
        if (!$vetResult) {
            return false;
        }

        $vet_id = $vetResult[0]->vet_id;
        $vetUpdateAvailabilityModel = new VetUpdateAvailableHoursModel();

        for ($i = 0; $i < count($_POST['day_of_week']); $i++) {
            $day_of_week = $_POST['day_of_week'][$i];
            $start_time = $_POST['start_time'][$i];
            $end_time = $_POST['end_time'][$i];
            $number_of_appointments = $_POST['number_of_appointments'][$i];

            $overlapQuery = "SELECT avl_id, booked_slots FROM vet_availability
                             WHERE vet_id = :vet_id AND day_of_week = :day_of_week
                             AND (
                                 (:start_time BETWEEN start_time AND end_time) 
                                 OR (:end_time BETWEEN start_time AND end_time)
                                 OR (start_time BETWEEN :start_time AND :end_time)
                                 OR (end_time BETWEEN :start_time AND :end_time)
                             )";

            $overlapParams = [
                'vet_id' => $vet_id,
                'day_of_week' => $day_of_week,
                'start_time' => $start_time,
                'end_time' => $end_time
            ];

            $overlapResult = $vetUpdateAvailabilityModel->query($overlapQuery, $overlapParams);

            if ($overlapResult) {
                $canDelete = true;

                foreach ($overlapResult as $slot) {
                    if ($slot->booked_slots > 0) {
                        $canDelete = false;
                        break;
                    }
                }

                if ($canDelete) {
                    // Delete old overlapping slots
                    $deleteQuery = "DELETE FROM vet_availability
                                    WHERE vet_id = :vet_id AND day_of_week = :day_of_week
                                    AND (
                                        (:start_time BETWEEN start_time AND end_time) 
                                        OR (:end_time BETWEEN start_time AND end_time)
                                        OR (start_time BETWEEN :start_time AND :end_time)
                                        OR (end_time BETWEEN :start_time AND :end_time)
                                    )";
                    $vetUpdateAvailabilityModel->query($deleteQuery, $overlapParams);

                    // Insert the new slot
                    $data = [
                        'vet_id'                 => $vet_id,
                        'day_of_week'            => $day_of_week,
                        'start_time'             => $start_time,
                        'end_time'               => $end_time,
                        'number_of_appointments' => $number_of_appointments
                    ];
                    $vetUpdateAvailabilityModel->insertAvailableHours($data);

                } else {
                    // Cannot update — booked appointments exist
                    echo "<script>alert('Cannot update availability for $day_of_week ($start_time - $end_time). Appointments are already booked in this time slot.');</script>";
                    // Skip insert, continue to next slot
                    continue;
                }

            } else {
                // No overlap — safe to insert new availability
                $data = [
                    'vet_id'                 => $vet_id,
                    'day_of_week'            => $day_of_week,
                    'start_time'             => $start_time,
                    'end_time'               => $end_time,
                    'number_of_appointments' => $number_of_appointments
                ];
                $vetUpdateAvailabilityModel->insertAvailableHours($data);
            }
        }

        return true;
    }
    return false;
}


    

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

