<?php

class PrescriptionModel 
{
    use Model;
    protected $table = 'prescription';
    protected $allowedColumns = ['prescription_id', 'pet_id', 'vet_id', 'special_note', 'created_at', 'time_stamp'];

    public function getPrescriptionDetails($prescription_id)
    {
        $query = "SELECT p.*, pet.pet_name, v.f_name as vet_name, po.owner_id 
                 FROM prescription p 
                 JOIN pet pet ON p.pet_id = pet.pet_id 
                 JOIN vet v ON p.vet_id = v.vet_id 
                 JOIN pet_owner po ON pet.owner_id = po.owner_id 
                 WHERE p.prescription_id = :prescription_id";

        $result = $this->query($query, [':prescription_id' => $prescription_id]);
        return $result ? $result[0] : false;
    }

    public function getPrescriptionMedicines($prescription_id)
    {
        $query = "SELECT pm.*, m.med_name 
                 FROM prescription_medicines pm 
                 JOIN medicine m ON pm.med_id = m.med_id 
                 WHERE pm.prescription_id = :prescription_id";

        return $this->query($query, [':prescription_id' => $prescription_id]);
    }

    public function getPetPrescriptions($pet_id)
    {
        $query = "SELECT p.*, v.f_name as vet_name 
                 FROM prescription p 
                 JOIN vet v ON p.vet_id = v.vet_id 
                 WHERE p.pet_id = :pet_id 
                 ORDER BY p.created_at DESC";

        return $this->query($query, [':pet_id' => $pet_id]);
    }
} 