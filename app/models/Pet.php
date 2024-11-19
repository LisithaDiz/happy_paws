<?php
class Pet {
    use Model;

    protected $table = 'pets';
    protected $allowedColumns = [
        'pet_id',
        'owner_id',
        'pet_name',
        'pet_type',
        'breed',
        'age',
        'color',
        'weight',
        'vaccinations',
        'date_of_birth',
    ];

    public function __construct() {
        $this->order_column = 'pet_id';
    }

    public function findAll() {
        try {
            $con = $this->connect(); // Ensure connect() is implemented in Model trait
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
            $con = $this->connect(); // Ensure connect() is implemented in the Model trait
            $query = "SELECT * FROM " . $this->table . " WHERE owner_id = :owner_id AND pet_id = :pet_id";
            $stm = $con->prepare($query);
            $stm->bindValue(':owner_id', $owner_id, PDO::PARAM_INT);
            $stm->bindValue(':pet_id', $pet_id, PDO::PARAM_INT);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC); // Use fetch() for a single record
        } catch (PDOException $e) {
            error_log("Error fetching record: " . $e->getMessage());
            return null; // Return null if no record is found or an error occurs
        }
    }
    
    public function deletePet($pet_id) {
        try {
            $con = $this->connect();
            $query = "DELETE FROM " . $this->table . " WHERE pet_id = :pet_id";
            $stm = $con->prepare($query);
            $stm->bindValue(':pet_id', $pet_id, PDO::PARAM_INT);
            $stm->execute();

            // Check if the pet was deleted
            return $stm->rowCount() > 0; // Returns true if at least one row was deleted
        } catch (PDOException $e) {
            error_log("Error deleting pet: " . $e->getMessage());
            return false;
        }
    }

    public function insert($data) {
        try {
            $con = $this->connect();
            $query = "INSERT INTO " . $this->table . " 
                      (owner_id, pet_name, pet_type, breed, age, color, weight, vaccinations, date_of_birth) 
                      VALUES (:owner_id, :pet_name, :pet_type, :breed, :age, :color, :weight, :vaccinations, :date_of_birth)";
            $stm = $con->prepare($query);
            return $stm->execute([
                ':owner_id' => $data['owner_id'],
                ':pet_name' => $data['pet_name'],
                ':pet_type' => $data['pet_type'],
                ':breed' => $data['breed'],
                ':age' => $data['age'],
                ':color' => $data['color'],
                ':weight' => $data['weight'],
                ':vaccinations' => $data['vaccinations'],
                ':date_of_birth' => $data['date_of_birth'],
            ]);
        } catch (PDOException $e) {
            error_log("Error inserting pet: " . $e->getMessage());
            return false;
        }
    }
    
    

}
?>
