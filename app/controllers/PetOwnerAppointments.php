<?php

class PetOwnerAppointments
{
    use Controller;

    public function index()
    {
        $vetAvailability = new VetUpdateAvailableHoursModel;

        $vetAvailabilityDetails = $vetAvailability->vetAvailabilityOwnerView();
        
        $this->view('petownerappointments', ['vetAvailabilityDetails'=> $vetAvailabilityDetails]);
    }
}
