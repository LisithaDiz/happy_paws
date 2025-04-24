<?php

class VetAvailability
{
    use Controller;

    public function index()
    {
        $vetUpdateAvailableHours = new VetUpdateAvailableHoursModel;

        $vetAvailabilityDetails = $vetUpdateAvailableHours->vetAvailabilityVetView();

        $vetApponitmentModel = new VetAppointmentModel;
        $vetAppointmentDetails = $vetApponitmentModel->appointmentDetailsVetView();

        $cancelledAppointmentDetails = $vetApponitmentModel->cancelledAppoinmentsVetView();
        // echo"availability                   "    ;
        // var_dump($vetAvailabilityDetails);
        // echo"appointments              ";
        // var_dump($vetAppointmentDetails);
        // echo"cancelled appointments                 ";
        // var_dump($cancelledAppointmentDetails);
        $this->view('vetavailability', ['vetAvailabilityDetails'=> $vetAvailabilityDetails,'vetAppointmentDetails'=> $vetAppointmentDetails,'cancelledAppointmentDetails'=>$cancelledAppointmentDetails]);

    }

    public function completeAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_id = $_POST['appointment_id'] ;
            
            $model = new VetAppointmentModel; 

            // Get current slots first
            $result = $model->completeAppointmentUpdate($appointment_id);
            
        
            if ($result) {
                // Redirect to the payment form with the necessary data (e.g., avl_id, vet_id)
                header("Location: " . ROOT . "/vetAvailability");
                exit; // Ensure no further code is executed after redirect
            } else {
                // Handle the case where the update failed (e.g., show an error message)
                echo "Error updating availability.";
            }
        }
    }

    public function cancelAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_id = $_POST['appointment_id'] ;
            
            $model = new VetAppointmentModel; 

            var_dump($appointment_id);
            // Get current slots first
            $result = $model->cancelAppointmentByVet($appointment_id);
            
        
            if ($result) {
                // Redirect to the payment form with the necessary data (e.g., avl_id, vet_id)
                header("Location: " . ROOT . "/vetAvailability");
                exit; // Ensure no further code is executed after redirect
            } else {
                // Handle the case where the update failed (e.g., show an error message)
                echo "Error updating availability.";
            }
        }
    }


    
}
