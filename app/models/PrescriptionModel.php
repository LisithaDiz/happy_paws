<?php 


/**
 * User class
 */
class PrescriptionModel
{
	
	use Model;

	protected $table = 'prescription';

	protected $allowedColumns = [
        'prescription_id',
        'pet_id',
        'vet_id',
        'special_note',
        'created_at'
	];

    public function insertPrescription($pet_id, $special_note)
    {
        $vet_id = $_SESSION['vet_id'];
        $query = "INSERT INTO prescription (pet_id, vet_id, special_note, created_at) 
                  VALUES (:pet_id, :vet_id, :special_note, NOW())";

        $this->query($query, [
            'pet_id' => $pet_id,
            'special_note' => $special_note,
            'vet_id' => $vet_id
        ]);

        $result = $this->query("SELECT prescription_id FROM prescription ORDER BY prescription_id DESC LIMIT 1");

        if (!empty($result)) {
            $lastid = $result[0]->prescription_id;
            return $lastid;
        } else {
            return null;
        }

        
    }

    public function getPrescriptionsDetails($petid)
    {
        $query = "SELECT * FROM prescription p
                JOIN prescription_medicines pm ON p.prescription_id = pm.prescription_id
                JOIN medicine m ON m.med_id = pm.med_id
                WHERE p.pet_id = :petid";

        $result = $this->query($query, ['petid'=>$petid]);

        return $result;

    }


}