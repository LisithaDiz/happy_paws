<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">

    

</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <div class="sidebar">
            <ul>
                <li><a href="<?=ROOT?>/VetDash">Dashboard</a></li>
                <li><a href="<?=ROOT?>/VetProfile">My Profile</a></li>
                <li><a href="<?=ROOT?>/VetAppoinment">Upcoming Appointments</a></li>
                <li><a href="<?=ROOT?>/VetRequest">Appointment Requests</a></li>    
                <li><a href="<?=ROOT?>/VetTreatedpet">View Pets</a></li>
                <li><a href="<?=ROOT?>/VetPrescription">Prescriptions</a></li>
                <li><a href="<?=ROOT?>/VetSettings">Settings</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <h1>Welcome, Dr. [Vet Name]!</h1>
            <p>We're glad to have you back. Your dashboard provides you with all the tools you need to manage appointments, pets records, prescriptions, and more.</p>

            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Upcoming Appointments</h3>
                        <p>3 appointments scheduled for today.</p>
                        <a href="<?=ROOT?>/vetappoinment" class="btn-dashboard">View upcoming appoinments</a>
                    </div>
                    <div class="card">
                        <h3>Appoinment Requests</h3>
                        <p>6 Requests received.</p>
                        <a href="<?=ROOT?>/vetrequest" class="btn-dashboard">View received requests</a>
                    </div>
                    <div class="card">
                        <h3>Prescriptions</h3>
                        <p>2 prescriptions to be filled today.</p>
                        <a href="<?=ROOT?>/vetprescription" class="btn-dashboard">View prescriptions</a>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="contact">
                <h2>Need Help?</h2>
                <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                <a href="<?=ROOT?>/vet/contact" class="btn-dashboard">Contact Support</a>
            </section>
        </div>

    </div>
    
    <?php include ('components/footer.php'); ?>
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->
   
</body>
</html>
