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
    public function findAllByOwnerId($owner_id) {
        try {
            // Validate owner_id input
            if (!is_numeric($owner_id)) {
                error_log("Invalid owner_id: must be an integer.");
                return [];
            }
    
            $con = $this->connect();
    
            // Query to fetch all pets for the given owner_id
            $query = "SELECT * FROM " . $this->table . " WHERE owner_id = :owner_id";
    
            $stm = $con->prepare($query);
            $stm->bindValue(':owner_id', $owner_id, PDO::PARAM_INT);
            $stm->execute();
    
            // Fetch and return all matching records
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching pets for owner_id $owner_id: " . $e->getMessage());
            return [];
        }
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
        header("Location: " . ROOT . "/PetOwnerDash");

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
        header("Location: " . ROOT . "/PetOwnerDash");

    }

    public function updatePet($pet_id, $data) {
        try {
            $con = $this->connect();
            $query = "UPDATE " . $this->table . " 
                      SET pet_name = :pet_name, 
                          pet_type = :pet_type, 
                          breed = :breed, 
                          age = :age, 
                          color = :color, 
                          weight = :weight, 
                          vaccinations = :vaccinations, 
                          date_of_birth = :date_of_birth 
                      WHERE pet_id = :pet_id";
    
            $stm = $con->prepare($query);
    
            // Bind the data values to the prepared statement
            $stm->bindValue(':pet_name', trim($data['pet_name']), PDO::PARAM_STR);
            $stm->bindValue(':pet_type', trim($data['pet_type']), PDO::PARAM_STR);
            $stm->bindValue(':breed', trim($data['breed']), PDO::PARAM_STR);
            $stm->bindValue(':age', intval($data['age']), PDO::PARAM_INT);
            $stm->bindValue(':color', trim($data['color']), PDO::PARAM_STR);
            $stm->bindValue(':weight', floatval($data['weight']), PDO::PARAM_STR);  // Correct binding for weight
            $stm->bindValue(':vaccinations', trim($data['vaccinations']), PDO::PARAM_STR);
            $stm->bindValue(':date_of_birth', trim($data['date_of_birth']), PDO::PARAM_STR);
            $stm->bindValue(':pet_id', intval($pet_id), PDO::PARAM_INT);
    
            // Execute the query and return whether the update was successful
            $result = $stm->execute();
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating pet: " . $e->getMessage());
            return false;
        }
        header("Location: " . ROOT . "/PetOwnerDash");

    }

    public function treatedPetDetails()
    {
        // echo"sssss";
        $userid = $_SESSION['user_id'];
        $query= "SELECT p.pet_id, p.pet_name, p.age, o.f_name, o.l_name
                FROM pets p
                JOIN pet_owner o ON p.owner_id = o.owner_id
                JOIN appointments a ON p.pet_id = a.pet_id
                JOIN veterinary_surgeon v ON v.vet_id = a.vet_id
                JOIN user u ON u.user_id = v.user_id
                WHERE u.user_id = :userid AND a.appointment_status = '1'";

        $params = ['userid'=>$userid];

        $result = $this->query($query,$params);

        return $result;


    }

    //owner pofile vet-view
    public function petDetailsVetView()
    {
        $ownerid = 1;
        $query = "SELECT * FROM pets
                WHERE owner_id = :ownerid";

        $result = $this->query($query,['ownerid'=>$ownerid]);
        return $result;
    }
    
    //selected pet's details
    public function petProfileVetView($petid)
    {
        $query = "SELECT * FROM pets
                WHERE pet_id = :petid";

        $result = $this->query($query, ['petid'=>$petid]);
        return $result;
    }


    
    public function getPetsByOwner($owner_id)
    {
        try {
            $query = "SELECT * FROM pet WHERE owner_id = :owner_id ORDER BY pet_name";
            return $this->query($query, [':owner_id' => $owner_id]);
        } catch (Exception $e) {
            error_log("Error in getPetsByOwner: " . $e->getMessage());
            return [];
        }
    }

    public function getPetById($pet_id)
    {
        try {
            $query = "SELECT * FROM pet WHERE pet_id = :pet_id LIMIT 1";
            $result = $this->query($query, [':pet_id' => $pet_id]);
            return $result ? $result[0] : null;
        } catch (Exception $e) {
            error_log("Error in getPetById: " . $e->getMessage());
            return null;
        }
    }
}




?>
