<?php

class VetView_PetProfile
{
    use Controller;

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pet_id'])) {
            // If pet_id is posted, store it in session for later use
            $_SESSION['pet_id'] = $_POST['pet_id'];
            $petid = $_POST['pet_id'];
        } elseif (isset($_SESSION['pet_id'])) {
            // If no new pet_id posted, use the stored one
            $petid = $_SESSION['pet_id'];
        } 
        $petModel = new Pet;
        $petDetails = $petModel->petProfileVetView($petid);

        $medicineModel = new MedicineModel;
        $medicineDetails = $medicineModel->getAllMedicines();

        $medicalhistoryModel = new MedicalRecordModel;
        $medicalhistoryDetails = $medicalhistoryModel->getMedicalHistory($petid);

        $prescriptionModel = new PrescriptionModel;
        $prescriptionDetails = $prescriptionModel->getPrescriptionsDetails($petid);

        
        $this->view('vetview_petprofile',['petDetails'=>$petDetails,'medicineDetails'=>$medicineDetails,'medicalHistoryDetails'=>$medicalhistoryDetails, 'prescriptionDetails'=>$prescriptionDetails]);
    }


    
    public function issueprescription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $pet_id = $_POST['pet_id'];
            $special_note = $_POST['special_note'];
            $medicinesJSON = $_POST['prescribed_medicines'];

            $medicineArray = json_decode($medicinesJSON, true);
           

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
                
            } else {
                echo "No medicines selected.";
            }


        }

        header("Location: " . ROOT . "/vetview_vetavailability");
        exit;
    }

    public function insertmedicalrecord()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $petid = $_POST['pet_id'];
            $vaccine = $_POST['vaccination_given'];
            $specialnote = $_POST['special_note'];
            $vetid = $_SESSION['vet_id'];
            
            $data = [
                'pet_id' => $petid,
                'vet_id' => $vetid,
                'vaccination_given' => $vaccine,
                'special_note' => $specialnote,
                'date' => date('Y-m-d')
            ];

            $medicalrecordModel = new MedicalRecordModel;
            $result = $medicalrecordModel->insert($data);   
            
            if ($result) {
                echo "<script>
                        alert('Updated medical record Sucessfully.');
                        window.location.href = '" . ROOT . "/vetview_petprofile';
                     </script>";
                     exit;
            } else {
                echo "<script>
                        alert('Error updating the medical record. Please try again.');
                        window.location.href = '" . ROOT . "/vetview_petprofile';
                     </script>";
                     exit;
            }

        }

    }

    public function updatemedicalrecord()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $record_id = $_POST['record_id'];
            $petid = $_POST['pet_id'];
            $vaccine = $_POST['vaccination_given'];
            $specialnote = $_POST['special_note'];
            $vetid = $_SESSION['vet_id'];

            $data = [
                'pet_id' => $petid,
                'vet_id' => $vetid,
                'vaccination_given' => $vaccine,
                'special_note' => $specialnote,
                'date' => date('Y-m-d')
            ];

            $medicalrecordModel = new MedicalRecordModel;
            $result = $medicalrecordModel->update($record_id, $data, 'record_id');

            if ($result) {
                echo "<script>
                        alert('Updated medical record Sucessfully.');
                        window.location.href = '" . ROOT . "/vetview_petprofile';
                    </script>";
                    exit;
            } else {
                echo "<script>
                        alert('Error updating the medical record. Please try again.');
                        window.location.href = '" . ROOT . "/vetview_petprofile';
                    </script>";
                    exit;
            }
        }

    }

    public function deletemedicalrecord()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $record_id = $_POST['record_id'];
            $medicalrecordModel = new MedicalRecordModel;
            $result = $medicalrecordModel->delete($record_id,'record_id');
            if ($result) {
                echo "<script>
                        alert('Medical record deleted sucessfully.');
                        window.location.href = '" . ROOT . "/vetview_petprofile';
                    </script>";
                    exit;
            } else {
                echo "<script>
                        alert('Error deleting the medical record. Please try again.');
                        window.location.href = '" . ROOT . "/vetview_petprofile';
                    </script>";
                    exit;
            }

        }
    }

}