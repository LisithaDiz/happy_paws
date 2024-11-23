<?php

class PetOwnerPrescriptions
{
    use Controller;

    public function index()
    {
        $this->view('petownerprescriptions');
    }
}