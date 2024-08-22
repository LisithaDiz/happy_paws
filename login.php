<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background-color: rgba(250, 185, 190, 0.8); 
        }
    </style>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="nav.css">

    
</head>
<body>
    <?php include ('nav.php'); ?>

    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="/login" method="POST">
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
                        <option value="petCarecenter">Pet Care Center</option>
                        <option value="pharmacy">Pharmacy</option>
                    </select>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Your Company. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
