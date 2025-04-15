<?php

class VetView_PetOwnerProfile{
    use Controller;

    public function index()
    {
        $petownermodel = new PetOwnerModel;
        $petownerDetails = $petownermodel ->ownerDetailsVetView();

        $petModel = new Pet();
        $petDetails = $petModel->petDetailsVetView();
        
        $this->view('vetview_petownerprofile',['petownerDetails'=>$petownerDetails,'petDetails'=>$petDetails]);
    }
}