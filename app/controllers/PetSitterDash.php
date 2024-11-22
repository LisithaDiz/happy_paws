<?php

class PetSitterDash
{
    use Controller;

    public function index()
    {
        $this->view('petsitterdash');
    }
}