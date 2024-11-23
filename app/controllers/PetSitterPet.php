<?php

class PetSitterPet
{
    use Controller;

    public function index()
    {
        $this->view('petsitterpet');
    }
}