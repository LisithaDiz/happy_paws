<?php
require_once 'db/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup.html');
    exit();
}
	
$conn = connectDatabase();

if ($conn) {
    echo "Connection successful!<br>";

    $username =  $conn->real_escape_string($_POST["username"]);
    $email =  $conn->real_escape_string($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $sql = '';
    
    $user_role = $_POST['user_role'];

        if ($user_role == 'petOwner') {
            
            $f_name	= $conn->real_escape_string($_POST["firstname"]);	
            $l_name	= $conn->real_escape_string($_POST["lastname"]);
            $age = $conn->real_escape_string($_POST["age"]);
            $owner_ID = $f_name . $l_name .$age;
            $district= $conn->real_escape_string($_POST["district"]);	
            $city = $conn->real_escape_string($_POST["city"]);		
            $street	= $conn->real_escape_string( $_POST["street"]);
            $contact_no= $conn->real_escape_string( $_POST["contact"]);	
            $num_pets= $conn->real_escape_string($_POST['pets']);

            $sql = "INSERT INTO pet_owner (owner_ID, username, email, password, f_name, l_name, age, district, city, street, contact_no, num_pets) VALUES ('$owner_ID', '$username', '$email', '$password', '$f_name', '$l_name', '$age', '$district', '$city', '$street', '$contact_no', '$num_pets')";


        } elseif ($user_role == 'veterinary') {
            $license_no = $conn->real_escape_string($_POST["license"]);
            $certificate = $conn->real_escape_string($_POST["vet_certificate"]);
            $f_name	= $conn->real_escape_string($_POST["firstname"]);	
            $l_name	= $conn->real_escape_string($_POST["lastname"]);
            $gender = $conn->real_escape_string($_POST["gender"]);
            $vet_ID = $f_name . $l_name .$license_no;
            $district= $conn->real_escape_string($_POST["district"]);	
            $city = $conn->real_escape_string($_POST["city"]);		
            $street	= $conn->real_escape_string( $_POST["street"]);
            $contact_no= $conn->real_escape_string( $_POST["contact"]);	
            $years_exp = $conn->real_escape_string( $_POST["years_exp"]);

            
            $sql = "INSERT INTO veterinary_surgeon (vet_ID,username, email, license_no, certificate, f_name, l_name, gender, district, city, street, years_exp,contact_no,password) VALUES ('$vet_ID ','$username', '$email', '$license_no', '$certificate', '$f_name', '$l_name', '$gender', '$district', '$city', '$street', '$years_exp','$contact_no','$password')";

        } elseif ($user_role == 'petSitter') {

            $f_name	= $conn->real_escape_string($_POST["firstname"]);	
            $l_name	= $conn->real_escape_string($_POST["lastname"]);
            $gender = $conn->real_escape_string($_POST["gender"]);
            $age = $conn->real_escape_string($_POST["age"]);
            $district= $conn->real_escape_string($_POST["district"]);	
            $city = $conn->real_escape_string($_POST["city"]);		
            $street	= $conn->real_escape_string( $_POST["street"]);
            $contact_no= $conn->real_escape_string( $_POST["contact"]);	
            $years_exp = $conn->real_escape_string( $_POST["years_exp"]);
            $pet_sitter_ID = $f_name.$l_name.$age;

            $sql = "INSERT INTO pet_sitter (pet_sitter_ID,username, email, f_name, l_name, gender, age, district, city, street, cont_num, years_exp, password) VALUES ('$pet_sitter_ID','$username', '$email', '$f_name', '$l_name', '$gender', '$age', '$district', '$city', '$street', '$contact_no', '$years_exp', '$password')";

        } else {
           
            $name = $conn->real_escape_string($_POST["name"]);
            $certificate = $conn->real_escape_string($_POST["certificate"]);
            $district= $conn->real_escape_string($_POST["district"]);	
            $city = $conn->real_escape_string($_POST["city"]);		
            $street	= $conn->real_escape_string( $_POST["street"]);
            $contact_no= $conn->real_escape_string( $_POST["contact"]);	

            if($user_role == 'petCareCenter') {
                $care_center__ID = $name . $street;
                $sql = "INSERT INTO pet_boarding_service (care_center_ID,username, email, name, certificate, district, city, street, contact_no,password) VALUES ('$care_center__ID','$username', '$email', '$name', '$certificate', '$district', '$city', '$street', '$contact_no','$password')";
            }else{
                $pharmacy_ID = $name . $street;
                $sql = "INSERT INTO pharmacy (pharmacy_ID,username, email, name, certificate, district, city, street, contact_no,password) VALUES ('$pharmacy_ID','$username', '$email', '$name', '$certificate', '$district', '$city', '$street', '$contact_no','$password')";

            }
        }

    
        if (!empty($sql) && $conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
    closeDatabase($conn);
    
}
else {
        echo "Connection failed!";
}
?>

