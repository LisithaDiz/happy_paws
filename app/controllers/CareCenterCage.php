<?php

class CareCenterCage
{
    use Controller;

    public function index()
    {   
        $center_id=$_SESSION['care_center_id'];
        $manageCageController = new cageModel();
		$cage =$manageCageController->getAllCages($center_id); 
		// var_dump($cage);

		$data =['cages' => $cage];
        $this->view('carecentercage',$data);
    }
}