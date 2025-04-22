<?php

class PetOwnerDash
{
    use Controller;

    public function index()
    {
        $this->view('petownerdash');
    }
}