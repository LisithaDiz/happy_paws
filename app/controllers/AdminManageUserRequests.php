<?php 

class AdminManageUserRequests
{
	use Controller;

	public function index()
	{
		$manageMedRequest = new MedRequestModel();
		$med_req =$manageMedRequest->getAllMedReq(); 
		// var_dump($med_req);

		$manageContactUs = new ContactUsModel();
		$contact_us = $manageContactUs->getAllContactUsInfo();

		$data =['med_requests' => $med_req,
				'contact_us_info' => $contact_us
				];
		$this->view('adminmanageuserrequests',$data);
		
	}

}
