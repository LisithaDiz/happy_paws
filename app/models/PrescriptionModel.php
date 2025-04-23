<?php

class PrescriptionModel 
{
    use Model;
    protected $table = 'prescription';
    protected $allowedColumns = ['prescription_id', 'pet_id', 'vet_id', 'special_note', 'created_at', 'time_stamp'];

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

    public function getPrescriptionDetails($prescription_id)
    {
        $query = "SELECT p.*, pet.pet_name, vs.f_name as vet_name, po.owner_id 
                 FROM prescription p 
                 JOIN pet pet ON p.pet_id = pet.pet_id 
                 JOIN veterinary_surgeon vs ON p.vet_id = vs.vet_id 
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
        error_log("getPetPrescriptions called with pet_id: " . $pet_id);
        
        try {
            // Get database connection
            $db = $this->connect();
            if (!$db) {
                error_log("Failed to connect to database");
                return false;
            }

            // Prepare the query
            $query = "SELECT p.*, vs.f_name as vet_name 
                     FROM prescription p 
                     JOIN veterinary_surgeon vs ON p.vet_id = vs.vet_id 
                     WHERE p.pet_id = :pet_id 
                     ORDER BY p.created_at DESC";

            error_log("Executing query: " . $query);
            error_log("With parameters: " . print_r([':pet_id' => $pet_id], true));

            // Prepare and execute the statement
            $stmt = $db->prepare($query);
            if (!$stmt) {
                error_log("Failed to prepare statement. Error: " . print_r($db->errorInfo(), true));
                return false;
            }

            $result = $stmt->execute([':pet_id' => $pet_id]);
            if (!$result) {
                error_log("Failed to execute statement. Error: " . print_r($stmt->errorInfo(), true));
                return false;
            }

            // Fetch the results
            $prescriptions = $stmt->fetchAll(PDO::FETCH_OBJ);
            error_log("Query result: " . print_r($prescriptions, true));

            if (empty($prescriptions)) {
                error_log("No prescriptions found for pet_id: " . $pet_id);
                return [];
            }

            return $prescriptions;
        } catch (PDOException $e) {
            error_log("PDO Exception in getPetPrescriptions: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        } catch (Exception $e) {
            error_log("General Exception in getPetPrescriptions: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
} 
