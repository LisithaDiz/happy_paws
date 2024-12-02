<?php

class PetSitterDashboard
{
    use Controller;

    public function index()
    {
        $this->view('petsitterdashboard');
    }
}