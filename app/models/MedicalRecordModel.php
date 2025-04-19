<?php 


/**
 * User class
 */
class MedicalRecordModel
{
	
	use Model;

	protected $table = 'medical_record';

	protected $allowedColumns = [

		'record_id',
        'pet_id',
        'vet_id',
        'date',
        'vaccination_given',
        'special_note',
        'created_at',
        'updated_at'
	];

    public function getMedicalHistory($petid)
    {

        $query = "SELECT * FROM medical_record
                WHERE pet_id = :petid";


        $result  = $this->query($query,['petid' => $petid]);
        return $result;
    }

	
}