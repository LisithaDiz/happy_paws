<?php

class PetOwnerView_CareCenterProfile
{
    use Controller;

    public function index()
    {

        $sitterid = $_POST['sitter_id'];
        $sittermodel = new PetSitterModel;
        $sitterDetails = $sittermodel->getSitterDetailsOwnerView($sitterid);
        $this->view('petownerview_carecenterprofile',['sitterDetails'=>$sitterDetails]);
    }
}