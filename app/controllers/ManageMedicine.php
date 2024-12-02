<?php 

class ManageMedicine
{
	use Controller;

	public function index()
	{
		$manageMedicineController = new MedicineModel();
		$medicine =$manageMedicineController->getAllMedicines(); 
		// var_dump($medicine);

		$data =['medicines' => $medicine];
		$this->view('managemedicines',$data);
	}

}
