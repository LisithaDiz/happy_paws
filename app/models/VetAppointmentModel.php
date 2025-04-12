<?php 


/**
 * User class
 */
class VetAppointmentModel
{
	
	use Model;

	protected $table = 'appointment';

	protected $allowedColumns = [

		'appointment_id',
		'vet_id', 
		'owner_id',
		'avl_id',
		'appointment_time', 
		'appointment_date',
		'appointment_status'
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




	public function appointmentDetailsOwnerView()
	{
		$ownerid = $_SESSION['owner_id'];
		

		$query="SELECT * FROM appointment a
				JOIN veterinary_surgeon v ON a.vet_id = v.vet_id
				WHERE a.owner_id = :ownerid  AND a.appointment_status = '0'";

			
		
		$params = ['ownerid'=> $ownerid];// key name must match the :ownerid in query

		$result = $this->query($query, $params);
		
		
		return $result;

	}

	public function cancelAppointmentUpdate($appointment_id)
	{
		// Step 1: Update appointment status to '2' (Cancelled)
		$updatestatus = "UPDATE appointment
						SET appointment_status = 2
						WHERE appointment_id = :appointment_id";

		$this->query($updatestatus, ['appointment_id' => $appointment_id]);

		// Step 2: Retrieve avl_id from the appointment
		$getavlid = "SELECT * FROM appointment WHERE appointment_id = :appointment_id";

		$appointment = $this->query($getavlid, ['appointment_id' => $appointment_id]);

		if (!empty($appointment)) {
			$avl_id = $appointment[0]->avl_id;  // Fetch from first row

			// Step 3: Update slots in vet_availability
			$updateslots = "UPDATE vet_availability
							SET booked_slots = booked_slots - 1,
								available_slots = available_slots + 1
							WHERE avl_id = :avl_id";

			$this->query($updateslots, ['avl_id' => $avl_id]);

			return true;
		} else {
			return false; // No appointment found
		}
	}


	
	public function cancelledAppoinmentsOwnerView()
	{
		$ownerid=$_SESSION['owner_id'];
		$query = "SELECT * FROM appointment  a
				JOIN veterinary_surgeon v ON a.vet_id = v.vet_id
				WHERE a.owner_id = :ownerid AND a.appointment_status = 2";

		$result = $this->query($query,['ownerid'=> $ownerid]);
		

		return $result;
	}





}