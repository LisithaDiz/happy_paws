<?php

class VetAvailability
{
    use Controller;

    public function index()
    {
        $vetUpdateAvailableHours = new VetUpdateAvailableHoursModel;

        $vetAvailabilityDetails = $vetUpdateAvailableHours->getAvailableHours();

        $this->view('vetavailability', ['vetAvailabilityDetails'=> $vetAvailabilityDetails]);

    }


    
}
