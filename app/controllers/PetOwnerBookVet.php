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
            $model = new VetUpdateAvailableHoursModel; // or AvailabilityModel

            // Get current slots first
            $current = $model->first(['avl_id' => $avl_id]);

        

            if ($current && $current->available_slots > 0) {
                // $data = [
                //     'booked_slots'    => $current->booked_slots + 1,
                //     'available_slots' => $current->available_slots - 1
                // ];
                
                // Now both fields are passed
                $updated = $model->updateAvailableSlots($avl_id);
                
            }
        }
    }
}