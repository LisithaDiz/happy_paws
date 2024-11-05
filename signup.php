<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup_role.php');
    exit();
}

$user_role = $_POST["user-type"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="assests/happy-paws-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="components/nav.css">
    <link rel="stylesheet" href="components/footer.css">

</head>
<body>
    <?php include ('components/nav.php'); ?>
        <div class="signup-box">
            <h2>Sign Up as a <?php echo ucfirst($user_role); ?></h2>
            <div class="card">
                <?php if ($user_role == 'petOwner'){?>
                    <img src="assests/prof/pet_owner_prof.jpg" alt="Pet Owner">
                    <p>Pet Owner</p>
                <?php } if ($user_role == 'veterinary'){?>
                    <img src="assests/prof/vet_prof.webp" alt="Veterinary Surgeon">
                    <p>Veterinary Surgeon</p>
                <?php }if ($user_role == 'petCareCenter'){?>
                    <img src="assests/prof/pet_care_center_prof.png" alt="Pet Care Center">
                    <p>Pet Care Center</p>
                <?php }if ($user_role == 'petSitter'){?>
                    <img src="assests/prof/pet_sitter_prof.png" alt="Pet Sitter">
                    <p>Pet Sitter</p>
                <?php }if ($user_role == 'pharmacy'){?>
                    <img src="assests/prof/pharmacy_prof.jpg" alt="Pharmacy">
                    <p>Pharmacy</p>
                <?php } ?>
            </div>

            <form action="signup_process.php" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                <input type="hidden" name="user_role" value="<?php echo $user_role; ?>">
                <!-- Common Fields -->
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>


                <!-- Role-Specific Fields -->
                <?php if ($user_role == 'petOwner'||$user_role == 'veterinary'||$user_role == 'petSitter') { ?>
                    <?php if($user_role =='veterinary'){ ?>

                        <label for="license">License Number</label>
                        <input type="text" id="license" name="license" required>
                        <!-- Certificate (file upload)  required -->
                        <label for="vet_certificate">Certificate:</label>
                        <input type="file" id="vet_certificate" name="vet_certificate"> 
                    <?php } ?>

                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" required>

                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" required>

                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" min="1" required>

                    <?php if($user_role =='veterinary'||$user_role == 'petSitter'){?>
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    <?php } ?>

                        <label for="district">District</label>
                        <select id="district" name="district" required>
                            <option value="" disabled selected>Select your district</option>
                            <option value="Colombo">Colombo</option>
                            <option value="Gampaha">Gampaha</option>
                            <option value="Kalutara">Kalutara</option>
                            <option value="Kandy">Kandy</option>
                            <option value="Matale">Matale</option>
                            <option value="Nuwara Eliya">Nuwara Eliya</option>
                            <option value="Galle">Galle</option>
                            <option value="Matara">Matara</option>
                            <option value="Hambantota">Hambantota</option>
                            <option value="Jaffna">Jaffna</option>
                            <option value="Kilinochchi">Kilinochchi</option>
                            <option value="Mannar">Mannar</option>
                            <option value="Vavuniya">Vavuniya</option>
                            <option value="Mullaitivu">Mullaitivu</option>
                            <option value="Batticaloa">Batticaloa</option>
                            <option value="Ampara">Ampara</option>
                            <option value="Trincomalee">Trincomalee</option>
                            <option value="Kurunegala">Kurunegala</option>
                            <option value="Puttalam">Puttalam</option>
                            <option value="Anuradhapura">Anuradhapura</option>
                            <option value="Polonnaruwa">Polonnaruwa</option>
                            <option value="Badulla">Badulla</option>
                            <option value="Moneragala">Moneragala</option>
                            <option value="Ratnapura">Ratnapura</option>
                            <option value="Kegalle">Kegalle</option>
                        </select>

                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>

                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" required>

                    <label for="contact">Contact No</label>
                    <input type="tel" id="contact" name="contact" required>

                    <?php if($user_role == 'petOwner'){?>
                        <label for="pets">Number of Pets</label>
                        <input type="number" id="pets" name="pets" min="0" required>
                    <?php } ?>

                    <?php if($user_role =='veterinary'||$user_role == 'petSitter'){?>
                        <label for="years_exp">Years of Experience</label>
                        <input type="number" id="years_exp" name="years_exp" min="0" step="1" required>
                    <?php } ?>
            
                <?php } ?>
                <?php if($user_role == 'petCareCenter' || $user_role == 'pharmacy'){?>                                                                                                    
                    <label for="name"><?php echo ucfirst($user_role);?> Name</label>
                    <input type="text" id="name" name="name" required>

                    <!-- Certificate (file upload)  required -->
                    <label for="certificate">Certificate</label>
                    <input type="file" id="certificate" name="certificate" accept=".cer,.crt,.pem,.pfx" > 

                    <!-- District -->
                    <label for="district">District</label>
                    <select id="district" name="district" required>
                        <option value="" disabled selected>Select your district</option>
                        <option value="Colombo">Colombo</option>
                        <option value="Gampaha">Gampaha</option>
                        <option value="Kalutara">Kalutara</option>
                        <option value="Kandy">Kandy</option>
                        <option value="Matale">Matale</option>
                        <option value="Nuwara Eliya">Nuwara Eliya</option>
                        <option value="Galle">Galle</option>
                        <option value="Matara">Matara</option>
                        <option value="Hambantota">Hambantota</option>
                        <option value="Jaffna">Jaffna</option>
                        <option value="Kilinochchi">Kilinochchi</option>
                        <option value="Mannar">Mannar</option>
                        <option value="Vavuniya">Vavuniya</option>
                        <option value="Mullaitivu">Mullaitivu</option>
                        <option value="Batticaloa">Batticaloa</option>
                        <option value="Ampara">Ampara</option>
                        <option value="Trincomalee">Trincomalee</option>
                        <option value="Kurunegala">Kurunegala</option>
                        <option value="Puttalam">Puttalam</option>
                        <option value="Anuradhapura">Anuradhapura</option>
                        <option value="Polonnaruwa">Polonnaruwa</option>
                        <option value="Badulla">Badulla</option>
                        <option value="Moneragala">Moneragala</option>
                        <option value="Ratnapura">Ratnapura</option>
                        <option value="Kegalle">Kegalle</option>
                    </select>

                    <!-- City -->
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>

                    <!-- Street -->
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" required>

                    <label for="contact">Contact No</label>
                    <input type="tel" id="contact" name="contact" required>
                    
                <?php } ?>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>

                <p id="error-message" style="color: red; display: none;">Passwords do not match!</p>
                </div>
                <button type="submit">Sign Up</button>
            </form>
        </div>
  
    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;

        if (password !== confirmPassword) {
            event.preventDefault(); // Prevent form submission
            document.getElementById('error-message').style.display = 'block'; // Show error message
            document.getElementById('password').value = ''; // Clear password field
            document.getElementById('confirm_password').value = ''; // Clear confirm password field
            document.getElementById('password').focus(); // Set focus on the password field
        }
    });
    </script>

    <?php include ('components/footer.php'); ?>

    <!-- <script src="script.js"></script> -->
</body>
</html>