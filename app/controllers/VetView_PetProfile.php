<?php

class VetView_PetProfile
{
    use Controller;

    public function index()
    {
        $petid = $_POST['pet_id'];
        $petModel = new Pet;
        $petDetails = $petModel->petProfileVetView($petid);

        $medicineModel = new MedicineModel;
        $medicineDetails = $medicineModel->getAllMedicines();

        
        $this->view('vetview_petprofile',['petDetails'=>$petDetails,'medicineDetails'=>$medicineDetails]);
    }


    
    public function issueprescription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $pet_id = $_POST['pet_id'];
            $special_note = $_POST['special_note'];
            $medicinesJSON = $_POST['prescribed_medicines'];

            $medicineArray = json_decode($medicinesJSON, true);
            var_dump($medicineArray);

            if (!empty($medicineArray)) {

                $prescriptionModel = new PrescriptionModel;
                $medicineModel = new PrescriptionMedicinesModel;

                // Insert into prescriptions table
                $prescription_id = $prescriptionModel->insertPrescription($pet_id, $special_note);

                // Loop through medicines and insert each
                foreach ($medicineArray as $medicine) {
                    $medicineModel->insertPrescribedMedicine(
                        $prescription_id,
                        $medicine['id'],
                        $medicine['dosage'],
                        $medicine['frequency']
                    );
                }
                header("Location: " . ROOT . "/vetview_petprofile");
                exit;
            } else {
                echo "No medicines selected.";
            }
        }
    }
}