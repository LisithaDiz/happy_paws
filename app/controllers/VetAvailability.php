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

        $this->view('vetavailability', ['vetAvailabilityDetails'=> $vetAvailabilityDetails,'vetAppointmentDetails'=> $vetAppointmentDetails]);

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
                header("Location: " . ROOT . "/paymentForm");
                exit; // Ensure no further code is executed after redirect
            } else {
                // Handle the case where the update failed (e.g., show an error message)
                echo "Error updating availability.";
            }
        }
    }


    
}
