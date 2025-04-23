<?php

class PetSitterRequest
{
    use Controller;

    public function index()
    {
        $this->view('petsitterrequest');
    }
}