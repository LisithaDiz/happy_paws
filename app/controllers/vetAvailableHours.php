<?php

class VetAvailableHours
{
    use Controller;

    public function index()
    {
        $this->view('VetAvailableHours');
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
    public function getAvailableHours()
    {
        $vetUpdateAvailabilityModel = new VetUpdateAvailableHoursModel();
        

    }

    public function availableHours()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userid = $_SESSION['user_id']; // Get the logged-in user ID
            
            $userModel = new UserModel();
            $query = "SELECT vet_id FROM veterinary_surgeon WHERE user_id = :user_id";
            $vetResult = $userModel->query($query, ['user_id' => $userid]);
            
            if (!$vetResult) {
                return false; // No vet found for this user
            }
    
            $vet_id = $vetResult[0]->vet_id; // Extract vet ID
            
            $vetUpdateAvailabilityModel = new VetUpdateAvailableHoursModel();
    
            // Loop through the form data and insert each availability
            for ($i = 0; $i < count($_POST['day_of_week']); $i++) {
                $day_of_week = $_POST['day_of_week'][$i];
                $start_time = $_POST['start_time'][$i];
                $end_time = $_POST['end_time'][$i];
                $number_of_appointments = $_POST['number_of_appointments'][$i];
    
                // Check for overlapping time slots
                $overlapQuery = "SELECT avl_id FROM vet_availability
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
                    // If overlapping slots exist, delete them
                    $deleteQuery = "DELETE FROM vet_availability
                                    WHERE vet_id = :vet_id AND day_of_week = :day_of_week
                                    AND (
                                        (:start_time BETWEEN start_time AND end_time) 
                                        OR (:end_time BETWEEN start_time AND end_time)
                                        OR (start_time BETWEEN :start_time AND :end_time)
                                        OR (end_time BETWEEN :start_time AND :end_time)
                                    )";
                    $vetUpdateAvailabilityModel->query($deleteQuery, $overlapParams);
                }
    
                // Insert the new availability
                $data = [
                    'vet_id'                 => $vet_id,
                    'day_of_week'            => $day_of_week,
                    'start_time'             => $start_time,
                    'end_time'               => $end_time,
                    'number_of_appointments' => $number_of_appointments
                ];
                $vetUpdateAvailabilityModel->insertAvailableHours($data);
            }
    
            return true; // Successfully updated availability
        }
        return false;
    }
    

  
}

