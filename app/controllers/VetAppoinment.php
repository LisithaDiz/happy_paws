<?php

class VetAppoinment
{
    use Controller;

    public function index()
    {
        $vetModel = new vetModel;

        $appointmentDetails = $vetModel->getAppointmentDetails();

        $this->view('VetAppoinment', ['appointmentDetails' => $appointmentDetails]);
    }
}
