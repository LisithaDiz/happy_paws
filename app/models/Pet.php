<?php
include_once __DIR__ . '/../includes/db.php';

class Pet
{
    protected $table = 'pets';

    // Fetch all pets
    public function getAllPets()
    {
        global $conn;
        $query = "SELECT * FROM {$this->table}";
        $result = $conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch a specific pet by ID
    public function getPetById($pet_id)
    {
        global $conn;
        $query = "SELECT * FROM {$this->table} WHERE pet_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $pet_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
