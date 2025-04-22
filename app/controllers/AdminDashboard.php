<?php 

class AdminDashboard
{
	use Controller;

	public function index()
	{
		$this->view('admindashboard');
	}

}