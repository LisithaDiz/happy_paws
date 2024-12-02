<?php 

/**
 * home class
 */
class ContactUs
{
	use Controller;

	public function index()
	{

		$this->view('contactus');
	}

}