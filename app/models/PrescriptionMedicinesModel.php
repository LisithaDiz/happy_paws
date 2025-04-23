<?php 


/**
 * User class
 */
class PrescriptionMedicinesModel
{
	
	use Model;

	protected $table = 'prescription_medicines';

	protected $allowedColumns = [
        'prescription_medicine_id',
        'prescription_id',
        'med_id',
        'dosage',
        'frequency'
	];

 

    public function insertPrescribedMedicine($prescription_id, $med_id, $dosage, $frequency)
    {
        $query = "INSERT INTO prescription_medicines (prescription_id, med_id, dosage, frequency) 
                  VALUES (:prescription_id, :med_id, :dosage, :frequency)";

        $result =  $this->query($query, [
            'prescription_id' => $prescription_id,
            'med_id' => $med_id,
            'dosage' => $dosage,
            'frequency' => $frequency
        ]);
        return $result;
    }

   
}


  