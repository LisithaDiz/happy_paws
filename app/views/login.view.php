
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/login.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">


    
</head>
<body>
    <?php include ('components/nav.php'); ?>

    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="login_process.php" method="POST">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <label for="selection">Login as:</label>
                    <select id="selection" name="selection" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="petOwner">Pet Owner</option>
                        <option value="veterinary">Veterinary Surgeon</option>
                        <option value="petSitter">Pet Sitter</option>
                        <option value="petCareCenter">Pet Care Center</option>
                        <option value="pharmacy">Pharmacy</option>
                    </select>
                </div>
                <button type="submit" class="login-button">Login</button>
                <div class="register-link">
                    <p>Don't have an account? <a href="signup_role">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>

    <!-- <script src="script.js"></script> -->
</body>
</html>
