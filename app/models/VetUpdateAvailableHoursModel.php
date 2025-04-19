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

	public function vetAvailabilityVetView()
	{
		
		$vetid = $_SESSION['vet_id'];

		$query = "SELECT * FROM vet_availability 
				WHERE vet_id = :vetid";
		

		$params = ['vetid'=>$vetid];

		$result = $this->query($query,$params);
		
		return $result;

	}

	public function vetAvailabilityOwnerView($vetid){
		
		

		$query = "SELECT a.vet_id,a.avl_id,a.day_of_week, a.start_time, end_time, a.number_of_appointments, a.available_slots, a.booked_slots,v.f_name,v.l_name
				FROM vet_availability a
				JOIN veterinary_surgeon v ON a.vet_id = v.vet_id 
				WHERE v.vet_id = :vetid AND a.available_slots > 0";
		

		$params = ['vetid'=>$vetid];

		$result = $this->query($query,$params);
		
		return $result;
	}

	public function updateAvailableSlots($avl_id)
	{
		$query = "UPDATE vet_availability
              SET booked_slots = booked_slots + 1,
                  available_slots = available_slots - 1
              WHERE avl_id = :avl_id";

    $this->query($query, ['avl_id' => $avl_id]);
	
	
	}
		
	
}