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

 

    public function insertPrescribedMedicine($prescription_id, $med_id, $dosage, $frequency,$quantity)
    {
        $query = "INSERT INTO prescription_medicines (prescription_id, med_id, dosage, frequency, quantity) 
                  VALUES (:prescription_id, :med_id, :dosage, :frequency, :quantity)";

        $result =  $this->query($query, [
            'prescription_id' => $prescription_id,
            'med_id' => $med_id,
            'dosage' => $dosage,
            'frequency' => $frequency,
            'quantity' => $quantity
        ]);
        return $result;
    }

   
}


  