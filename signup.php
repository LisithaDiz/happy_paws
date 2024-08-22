<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
    <?php include ('nav.php'); ?>

    <div class="signup-container">
        <div class="signup-box">
            <h2>Sign Up</h2>
            <form id="signupForm" action="/happy_paws/processSignup.php" method="POST">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                </div>
                <div class="input-group">
                    <label for="contact">Contact Number:</label>
                    <input type="text" id="contact" name="contact" placeholder="XXXXXXXXXX" required>
                </div>
                <div class="input-group">
                    <label for="user-type">Sign up as:</label>
                    <select id="user-type" name="user-type" onchange="showAdditionalFields()" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="petOwner">Pet Owner</option>
                        <option value="veterinary">Veterinary Surgeon</option>
                        <option value="petSitter">Pet Sitter</option>
                        <option value="petCarecenter">Pet Care Center</option>
                        <option value="pharmacy">Pharmacy</option>
                    </select>
                </div>
                
                <div id="petOwnerFields" class="additional-fields" style="display: none;">
                <div class="input-group">
                        <label for="numPets">Pet Name:</label>
                        <input type="text" id="numPets" name="numPets" placeholder="No. of pets">
                    </div>
                    <!-- <div class="input-group">
                        <label for="petName">Pet Name:</label>
                        <input type="text" id="petName" name="petName" placeholder="Your Pet's Name">
                    </div> -->
                    <!-- <div class="input-group">
                        <label for="pet-category">Pet Category:</label>
                        <select id="pet-category" name="pet-category">
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="bird">Bird</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="pet-breed">Pet Breed:</label>
                        <input type="text" id="pet-breed" name="pet-breed" placeholder="Pet Breed">
                    </div>
                    <div class="input-group">
                        <label for="pet-age">Pet Age:</label>
                        <input type="number" id="pet-age" name="pet-age" placeholder="Pet Age">
                    </div> -->
                </div>
                
                <div id="veterinaryFields" class="additional-fields" style="display: none;">
                    <div class="input-group">
                        <label for="licenseNumber">License Number:</label>
                        <input type="text" id="licenseNumber" name="licenseNumber" placeholder="Your License Number">
                    </div>
                    <div class="input-group">
                        <label for="experience">Experience (years):</label>
                        <input type="number" id="experience" name="experience" placeholder="Years of Experience">
                    </div>
                    <div class="input-group">
                        <label for="vet-certificate">Upload Veterinary Certificate:</label>
                        <input type="file" id="vet-certificate" name="vet-certificate">
                    </div>
                </div>
                
                <div id="petSitterFields" class="additional-fields" style="display: none;">
                    <div class="input-group">
                        <label for="experience">Experience (years):</label>
                        <input type="number" id="experience" name="experience" placeholder="Years of Experience">
                    </div>
                </div>
                
                <div id="petCareCenterFields" class="additional-fields" style="display: none;">
                    <div class="input-group">
                        <label for="centerName">Center Name:</label>
                        <input type="text" id="centerName" name="centerName" placeholder="Your Care Center's Name">
                    </div>
                    <div class="input-group">
                        <label for="licenseNumber">License Number:</label>
                        <input type="text" id="licenseNumber" name="licenseNumber" placeholder="Your License Number">
                    </div>
                    <div class="input-group">
                        <label for="carecenter-certificate">Upload Care Center Certificate:</label>
                        <input type="file" id="carecenter-certificate" name="carecenter-certificate">
                    </div>
                </div>
                
                <div id="pharmacyFields" class="additional-fields" style="display: none;">
                    <div class="input-group">
                        <label for="pharmacyName">Pharmacy Name:</label>
                        <input type="text" id="pharmacyName" name="pharmacyName" placeholder="Your Pharmacy's Name">
                    </div>
                    <div class="input-group">
                        <label for="licenseNumber">License Number:</label>
                        <input type="text" id="licenseNumber" name="licenseNumber" placeholder="Your License Number">
                    </div>
                    <div class="input-group">
                        <label for="pharmacy-certificate">Upload Pharmacy Certificate:</label>
                        <input type="file" id="pharmacy-certificate" name="pharmacy-certificate">
                    </div>
                </div>
                
                <button type="submit" class="signup-button">Sign Up</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Your Company. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
