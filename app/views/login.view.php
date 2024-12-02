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

    <!-- Display error message if present -->
    <?php if (!empty($error)): ?>
        <div class="error-message">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="<?=ROOT?>/user/login" method="POST">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="input-group">
            <label for="user_role">Login as:</label>
            <select id="user_role" name="user_role" required>
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

    <script>
        function validateForm() {
            // Get form field values
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const userRole = document.getElementById('user_role').value;

            // Check if username is empty
            if (username === "") {
                alert("Please enter your username.");
                return false;
            }

            // Check if password is empty
            if (password === "") {
                alert("Please enter your password.");
                return false;
            }

            // Check if a role is selected
            if (userRole === "") {
                alert("Please select a login role.");
                return false;
            }

            // If all checks pass
            return true;
        }
    </script>
</body>
</html>
