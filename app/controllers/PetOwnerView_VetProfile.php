<?php

class PetOwnerView_VetProfile
{
    use Controller;

    public function index()
    {

        $vetid = $_POST['vet_id'];
        $vetmodel = new VetModel;
        $vetDetails = $vetmodel->getVetDetailsOwnerView($vetid);
        $this->view('petownerview_vetprofile',['vetDetails'=>$vetDetails]);
    }
}