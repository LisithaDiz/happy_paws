<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "happy_paws";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
$contact = $_POST['contact'];
$userType = $_POST['user-type'];

switch ($userType) {
    case 'petOwner':
        $numPets = $_POST['numPets'];
        $sql = "INSERT INTO pet_owner (username, email, pw, contact_no, num_pets) 
                VALUES ('$username', '$email', '$password', '$contact','$numPets')";
        break;

    case 'veterinary':
        $licenseNumber = $_POST['licenseNumber'];
        $yearsExp = $_POST['experience'];

        $sql = "INSERT INTO veterinary_surgeon (username, email, pw, license_no, years_exp,contact_no) 
                VALUES ('$username', '$email', '$password', '$licenseNumber', '$yearsExp', '$contact')";
        break;

    case 'petSitter':
        $experience = $_POST['experience'];

        $sql = "INSERT INTO PetSitter (username, email, pw, contact_no, experience) 
                VALUES ('$username', '$email', '$password', '$contact','$experience')";
        break;

    case 'petCarecenter':
        $centerName = $_POST['centerName'];
        $licenseNumber = $_POST['licenseNumber'];

        $sql = "INSERT INTO CareCenter (username, email, pw, contact, centerName, licenseNumber) 
                VALUES ('$username', '$email', '$password','$contact', '$centerName', '$licenseNumber')";
        break;

    case 'pharmacy':
        $pharmacyName = $_POST['pharmacyName'];
        $licenseNumber = $_POST['licenseNumber'];

        $sql = "INSERT INTO pharmacy (username, email, pw, pharmacy_name, license_no) 
                VALUES ('$username', '$email', '$password', '$pharmacyName', '$licenseNumber')";
        break;

    default:
        die("Invalid user type");
}

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
