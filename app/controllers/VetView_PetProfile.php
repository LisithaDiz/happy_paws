<?php

class VetView_PetProfile
{
    use Controller;

    public function index()
    {
        $petid = $_POST['pet_id'];
        $petModel = new Pet;
        $petDetails = $petModel->petProfileVetView($petid);
        

        
        $this->view('vetview_petprofile',['petDetails'=>$petDetails]);
    }
}