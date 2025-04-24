<?php

class VetDashboard
{
    use Controller;

    public function index()
    {
        $vetModel = new VetModel;
        $vetDetails = $vetModel->getVetDetails();
        $this->view('vetdashboard',['vetDetails'=>$vetDetails]);
    }
}



