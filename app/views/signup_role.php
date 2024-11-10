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
    <div class="signup-container">
        <div class="signup-box">
            <h2>Sign Up</h2>
            <form action="signup.php" method="POST">
                
                <div class="input-group">
                    <label for="user-type">Sign up as:</label>
                    <select id="user-type" name="user-type" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="petOwner">Pet Owner</option>
                        <option value="veterinary">Veterinary Surgeon</option>
                        <option value="petSitter">Pet Sitter</option>
                        <option value="petCareCenter">Pet Care Center</option>
                        <option value="pharmacy">Pharmacy</option>
                    </select>
                </div>
                <button type="submit" class="signup-button">Next</button>
            </form>
        </div>
    </div>
    
    <?php include ('components/footer.php'); ?>

    <!-- <script src="script.js"></script> -->
</body>
</html>
