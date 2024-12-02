<?php

class PetSitterProfile
{
    use Controller;

    public function index()
    {
        $this->view('petsitterprofile');
    }
}