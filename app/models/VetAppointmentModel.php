<?php 


/**
 * User class
 */
class VetAppointmentModel
{
	
	use Model;

	protected $table = 'appointments';

	protected $allowedColumns = [

		'appointment_id',
		'pet_id', 
		'startTime', 
		'endTime',
		'appointment_status',
		'vet_id'
	];

	// public function getFirstVetDetails()    
	// {
	// 	// Define the SQL query
	// 	$query = "SELECT user.username, user.email, veterinary_surgeon.license_no, 
	// 					veterinary_surgeon.f_name, veterinary_surgeon.l_name, 
	// 					veterinary_surgeon.age, veterinary_surgeon.gender, 
	// 					veterinary_surgeon.district, veterinary_surgeon.city, 
	// 					veterinary_surgeon.contact_no, 
	// 					veterinary_surgeon.years_exp
	// 			FROM user
	// 			JOIN veterinary_surgeon 
	// 			ON user.user_id = veterinary_surgeon.user_id 
	// 			LIMIT 1";

	// 	// Execute the query and store the result
	// 	$result = $this->query($query);

	// 	// Return the result
	// 	return $result;
	// }




	public function getAppointmentDetails()
	{
		$userid = $_SESSION['user_id'];
		

		$query="SELECT appointments.appointment_id,appointments.pet_id, appointments.startTime, appointments.endTime, pets.pet_name
				FROM appointments
				JOIN pets ON appointments.pet_id = pets.pet_id
				JOIN veterinary_surgeon ON veterinary_surgeon.vet_id = appointments.vet_id
				JOIN user ON user.user_id = veterinary_surgeon.user_id
				WHERE user.user_id = :userid  AND appointment_status = '0'";

			

		$params = ['userid'=> $userid];

		$result = $this->query($query, $params);
		
		return $result;

	}






		
	
}