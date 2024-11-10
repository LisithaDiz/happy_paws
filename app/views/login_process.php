<?php
require_once 'db/db_connect.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

$conn = connectDatabase();
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['selection'];

// Determine the table name based on the role
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
        echo "<script>alert('Invalid role selected.');</script>";
        exit();
}

// Sanitize inputs to prevent SQL injection
$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

// Construct the query
$query = "SELECT * FROM $table WHERE username = '$username'";
$result = $conn->query($query);

if ($result) {
    $user = $result->fetch_assoc();

    if ($user && $password == $user['password']) { 
    // if ($user && password_verify($password, $user['password'])) {
        
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $role;
        $_SESSION['table'] = $table;

        switch ($role) {
            case 'petOwner':
                $_SESSION['user_id'] = $user['owner_ID'];
                header("Location: pet_owner_dash.php");
                break;
            case 'veterinary':
                header("Location: veterinary_dash.php");
                break;
            case 'petSitter':
                header("Location: pet_sitter_dash.php");
                break;
            case 'petCareCenter':
                header("Location: pet_care_center_dash.php");
                break;
            case 'pharmacy':
                header("Location: pharmacy_dash.php");
                break;
            default:
                header("Location: login.php");
                break;
        }
        exit();
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }
} else {
    echo "<script>alert('Database query error.');</script>";
}
?>
