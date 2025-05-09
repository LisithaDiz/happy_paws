<?php 

class AdminManageUsers
{
	use Controller;

	// public function index()
	// {

	// 	$this->view('adminmanageusers');
	// }

	public function index()
    {
        // Load the model
        // $userModel = $this->loadModel('UserModel');
        
        // // Fetch users by type
        // $petOwners = $petOwnerController->getUsersByType('Pet Owner');
        // $vets = $userModel->getUsersByType('Veterinarian');
        // $petSitters = $userModel->getUsersByType('Pet Sitter');
        // $petCareCenters = $userModel->getUsersByType('Pet Care Center');
        // $pharmacies = $userModel->getUsersByType('Pharmacy');

        // // Pass data to the view
        // $this->view('manageusers', [
        //     'petOwners' => $petOwners,
        //     'vets' => $vets,
        //     'petSitters' => $petSitters,
        //     'petCareCenters' => $petCareCenters,
        //     'pharmacies' => $pharmacies
        // ]);

		$petOwnerController = new petOwnerModel();
		$petOwner =$petOwnerController->getAllInfo();
		$vetController = new VetModel();
		$vet =$vetController->getAllInfo(); 
		$petSitterController = new PetSitterModel();
		$petSitter =$petSitterController->getAllInfo(); 
		$careCenterController = new CareCenterModel;
		$careCenter =$careCenterController->getAllInfo(); 
		$pharmacyController = new PharmacyModel();
		$Pharmacy =$pharmacyController->getAllInfo();  
		// var_dump($petOwner);
		// var_dump($vet);
		// var_dump($petSitter);
		// var_dump($careCenter);
		// var_dump($Pharmacy);

		$data =['petOwners' => $petOwner,
		'vets' => $vet,
		'petSitters' => $petSitter,
		'careCenters' => $careCenter,
		'pharmacies' => $Pharmacy];

		$this->view('adminmanageusers',$data);
    }




}

