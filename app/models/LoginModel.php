<?php
class LoginModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTableByRole($username, $role) {
        $table = '';

        switch ($role) {
            case 'petOwner':
                $table = 'pet_owner';
                break;
            case 'veterinary':
                $table = 'veterinary_surgeon';
                break;
            case 'petSitter':
                $table = 'pet_sitter';
                break;
            case 'petCareCenter':
                $table = 'pet_boarding_service';
                break;
            case 'pharmacy':
                $table = 'pharmacy';
                break;
            default:
                return false;
        }

        $username = $this->conn->real_escape_string($username);
        $query = "SELECT * FROM $table WHERE username = '$username'";
        $result = $this->conn->query($query);
        return $result ? $result->fetch_assoc() : false;
    }
}
?>
