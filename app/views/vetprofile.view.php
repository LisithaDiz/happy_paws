<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetprofile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">

    

</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <div class="sidebar">
            <h3>Vet Dashboard</h3>
            <ul>
                <li><a href="<?=ROOT?>/vet/profile">My Profile</a></li>
                <li><a href="<?=ROOT?>/vetappoinment">Upcoming Appointments</a></li>
                <li><a href="<?=ROOT?>/vetrequest">Appointment Requests</a></li>    
                <li><a href="<?=ROOT?>/vet/view-patients">View Pets</a></li>
                <li><a href="<?=ROOT?>/vet/prescriptions">Prescriptions</a></li>
                <li><a href="<?=ROOT?>/vet/settings">Settings</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            

            <div class="profile-picture">
                <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Profile Picture">
            </div>

            <div class="profile-details">
                <h1>-------------------------------Vet Profile-------------------------------</h1>
                <p><strong>Username                 :</strong>  johndoe</p>
                <p><strong>Email                    :</strong>  johndoe@example.com</p>
                <p><strong>Password:</strong> ********</p>
                <p><strong>Created Date:</strong> 2024-11-12</p>
                <p><strong>License No:</strong> 123456</p>
                <p><strong>First Name:</strong> John</p>
                <p><strong>Last Name:</strong> Doe</p>
                <p><strong>Age:</strong> 35</p>
                <p><strong>Gender:</strong> Male</p>
                <p><strong>District:</strong> Downtown</p>
                <p><strong>City:</strong> Metropolis</p>
                <p><strong>Contact No:</strong> +123456789</p>
                <p><strong>Years of Experience:</strong> 10</p>
            </div>
        </div>

    </div>
    
    <?php include ('components/footer.php'); ?>
   
    <script src="<?=ROOT?>/assets/js/script.js"></script>
   
</body>
</html>