<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/adminlogin.css">
    
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <!-- Display Error Message if Any -->
        <div class="error" id="errorMessage"></div>

        <!-- Display Success Message if Any -->
        <div class="success" id="successMessage"></div>

        <form action="admin/adminLogin" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>
