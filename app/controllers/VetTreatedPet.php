<?php

class VetTreatedPet
{
    use Controller;

    public function index()
    {
        $petModel = new Pet;
        $petDetails = $petModel->treatedPetDetails();
        
        $this->view('VetTreatedpet',['petDetails'=>$petDetails]);
    }
}
