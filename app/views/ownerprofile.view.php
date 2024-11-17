<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/ownerprofile.css">
    <link rel="stylesheet" href="assets/css/components/nav.css">
    <link rel="stylesheet" href="assets/css/components/footer.css">
</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for pet owner functionalities -->
        <div class="sidebar">
            <h3>Pet Owner Dashboard</h3>
            <ul>
                <li><a href="ownerpetsprofile">My Profile</a></li>
                <li><a href="ownerpetsprofiledash">My Pets</a></li>
                <li><a href="pet-tips">Pet Care Tips</a></li>
                <li><a href="settings">Settings</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <div class="profile-picture">
                <img src="assets/images/default-profile-picture.webp" alt="Profile Picture">
            </div>

            <div class="profile-details">
                <h1>----------------------------Pet Owner Profile----------------------------</h1>
                <p><strong>Username:</strong> john_doe123</p>
                <p><strong>Email:</strong> johndoe@example.com</p>
                <p><strong>Password:</strong> ********</p>
                <p><strong>Created Date:</strong> 2024-01-15</p>
                <p><strong>First Name:</strong> John</p>
                <p><strong>Last Name:</strong> Doe</p>
                <p><strong>Age:</strong> 32</p>
                <p><strong>Gender:</strong> Male</p>
                <p><strong>District:</strong> Colombo</p>
                <p><strong>City:</strong> Colombo</p>
                <p><strong>Contact No:</strong> +94 77 123 4567</p>
                <p><strong>Number of Pets:</strong> 2</p>
            </div>
        </div>
    </div>
    
    <?php include ('components/footer.php'); ?>
   
    <script src="assets/js/script.js"></script>
</body>
</html>
