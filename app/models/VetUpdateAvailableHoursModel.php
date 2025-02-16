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
		'number_of_appointments'
	];

    public function insertAvailableHours($data)
    {
       
		
		$query = "INSERT INTO vet_availability (vet_id, day_of_week, start_time, end_time, number_of_appointments) 
              VALUES (:vet_id, :day_of_week, :start_time, :end_time, :number_of_appointments)";
    
        $result= $this->query($query, $data);

		return $result;

	
    }
		
	
}