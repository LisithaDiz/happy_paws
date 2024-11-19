<?php
// Pet.php (Model)
class Pet {
    use Model;

    protected $table = 'pets';
    protected $allowedColumns = [
        'pet_id', 'owner_id', 'pet_name', 'pet_type', 'breed', 
        'age', 'color', 'weight', 'vaccinations', 'date_of_birth'
    ];

    public function __construct() {
        $this->order_column = 'pet_id';
    }

    public function findAll() {
        try {
            $con = $this->connect();
            $query = "SELECT * FROM " . $this->table;
            $stm = $con->prepare($query);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching records: " . $e->getMessage());
            return [];
        }
    }

    public function findByOwnerAndPet($owner_id, $pet_id) {
        try {
            $con = $this->connect();
            $query = "SELECT * FROM " . $this->table . " WHERE owner_id = :owner_id AND pet_id = :pet_id";
            $stm = $con->prepare($query);
            $stm->bindValue(':owner_id', $owner_id, PDO::PARAM_INT);
            $stm->bindValue(':pet_id', $pet_id, PDO::PARAM_INT);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching record: " . $e->getMessage());
            return null;
        }
    }
    
    public function deletePet($pet_id) {
        try {
            $con = $this->connect();
            $query = "DELETE FROM " . $this->table . " WHERE pet_id = :pet_id";
            $stm = $con->prepare($query);
            $stm->bindValue(':pet_id', $pet_id, PDO::PARAM_INT);
            $stm->execute();
            return $stm->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting pet: " . $e->getMessage());
            return false;
        }
    }

    public function insertPet($data) {
        try {
            $con = $this->connect();
            
            // Debug: Check database connection
            if (!$con) {
                error_log("Database connection failed");
                return false;
            }

            $query = "INSERT INTO pets 
                      (owner_id, pet_name, pet_type, breed, age, color, weight, vaccinations, date_of_birth) 
                      VALUES (:owner_id, :pet_name, :pet_type, :breed, :age, :color, :weight, :vaccinations, :date_of_birth)";
            
            $stm = $con->prepare($query);

            // Validate and convert data types
            $stm->bindValue(':owner_id', intval($data['owner_id']), PDO::PARAM_INT);
            $stm->bindValue(':pet_name', trim($data['pet_name']), PDO::PARAM_STR);
            $stm->bindValue(':pet_type', trim($data['pet_type']), PDO::PARAM_STR);
            $stm->bindValue(':breed', trim($data['breed']), PDO::PARAM_STR);
            $stm->bindValue(':age', intval($data['age']), PDO::PARAM_INT);
            $stm->bindValue(':color', trim($data['color']), PDO::PARAM_STR);
            $stm->bindValue(':weight', floatval($data['weight']), PDO::PARAM_STR); // Use PDO::PARAM_STR for float
            $stm->bindValue(':vaccinations', trim($data['vaccinations']), PDO::PARAM_STR);
            $stm->bindValue(':date_of_birth', trim($data['date_of_birth']), PDO::PARAM_STR);

            $result = $stm->execute();

            // Debug: Log any execution errors
            if (!$result) {
                $errorInfo = $stm->errorInfo();
                error_log("Insert Error: " . print_r($errorInfo, true));
            }

            return $result;
        } catch (PDOException $e) {
            error_log("PDO Exception: " . $e->getMessage());
            return false;
        }
    }
}
?>
