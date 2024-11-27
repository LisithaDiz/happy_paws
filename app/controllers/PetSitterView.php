<?php

class PetSitterView
{
    use Controller;

    public function index()
    {
        $this->view('petsitterview');
    }
}