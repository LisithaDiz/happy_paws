<?php

class PetOwnerBookVet 
{
    use Controller;

    public function index()
    {
        
        $vetAvailability = new VetUpdateAvailableHoursModel;

        $vetAvailabilityDetails = $vetAvailability->vetAvailabilityOwnerView();
        $this->view('petownerbookvet', ['vetAvailabilityDetails'=> $vetAvailabilityDetails]);
    }

    public function bookvet()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vet_id = $_POST['vet_id'] ;
            $avl_id = $_POST['avl_id'] ;
            $date = $_POST['date'];
            $exact_time = $_POST['exact_time'];
            $owner_id = $_SESSION['owner_id'];
            $model = new VetUpdateAvailableHoursModel; // or AvailabilityModel
            $appointmentmodel = new VetAppointmentModel;

            // Get current slots first
            $current = $model->first(['avl_id' => $avl_id]);
            $data = [
                'vet_id'            => $vet_id,
                'owner_id'          => $owner_id,
                'avl_id'            => $avl_id,
                'appointment_date'  => $date,
                'appointment_time'  => $exact_time
            ];
        

            if ($current && $current->available_slots > 0) {
                // $data = [
                //     'booked_slots'    => $current->booked_slots + 1,
                //     'available_slots' => $current->available_slots - 1
                // ];
                
                // Now both fields are passed
                $model->updateAvailableSlots($avl_id);
                
                $result=$appointmentmodel->insert($data);
                
                
            }

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