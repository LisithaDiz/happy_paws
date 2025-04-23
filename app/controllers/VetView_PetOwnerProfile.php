<?php

class VetView_PetOwnerProfile{
    use Controller;

    public function index()
    {
       
        $petownermodel = new PetOwnerModel;
        $owner_id = $_POST['owner_id'];
        $petownerDetails = $petownermodel ->ownerDetailsVetView($owner_id);

        $petModel = new Pet();
        $petDetails = $petModel->petDetailsVetView();
        
        $this->view('vetview_petownerprofile',['petownerDetails'=>$petownerDetails,'petDetails'=>$petDetails]);
    }
}