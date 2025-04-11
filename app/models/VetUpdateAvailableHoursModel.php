<?php 


/**
 * User class
 */
class VetUpdateAvailableHoursModel
{
	
	use Model;

	protected $table = 'vet_availability';

	protected $allowedColumns = [

		'avl_id',
		'vet_id', 
		'day_of_week', 
		'start_time',
		'end_time',
		'number_of_appointments',
		'available_slots'
	];

    public function insertAvailableHours($data)
    {
       
		
		$query = "INSERT INTO vet_availability (vet_id, day_of_week, start_time, end_time, number_of_appointments) 
              VALUES (:vet_id, :day_of_week, :start_time, :end_time, :number_of_appointments)";
    
        $result= $this->query($query, $data);

		return $result;

	
    }

	public function getAvailableHours()
	{
		
		$userid = $_SESSION['user_id'];

		$query = "SELECT a.day_of_week, a.start_time, end_time, a.number_of_appointments
				FROM vet_availability a
				JOIN veterinary_surgeon v ON a.vet_id = v.vet_id 
				WHERE v.user_id = :userid";
		

		$params = ['userid'=>$userid];

		$result = $this->query($query,$params);
		
		return $result;

	}

	public function vetAvailabilityOwnerView(){
		
		$userid = 7;

		$query = "SELECT a.vet_id,a.avl_id,a.day_of_week, a.start_time, end_time, a.number_of_appointments, a.available_slots,v.f_name,v.l_name
				FROM vet_availability a
				JOIN veterinary_surgeon v ON a.vet_id = v.vet_id 
				WHERE v.user_id = :userid";
		

		$params = ['userid'=>$userid];

		$result = $this->query($query,$params);
		
		return $result;
	}

	public function updateAvailableSlots($avl_id)
	{
		$query = "UPDATE vet_availability
              SET booked_slots = booked_slots + 1,
                  available_slots = available_slots - 1
              WHERE avl_id = :avl_id";

    $result= $this->query($query, ['avl_id' => $avl_id]);
	
	if ($result) {
        // Redirect to the payment form with the necessary data (e.g., avl_id, vet_id)
        header("Location: " . ROOT . "/paymentForm");
        exit; // Ensure no further code is executed after redirect
    } else {
        // Handle the case where the update failed (e.g., show an error message)
        echo "Error updating availability.";
    }
	}
		
	
}