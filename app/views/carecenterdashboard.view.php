<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecenterdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">



    

</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
       
        <?php include ('components/sidebar5.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <h1>Welcome, [Pet Care Center Name]!</h1>
            <p>Your dashboard is designed to help you seamlessly manage your pet care center, monitor activities, and provide top-notch care for all pets.</p>

            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>View Pets</h3>
                        <p>Check all pets currently at your center.</p>
                        <a href="<?=ROOT?>/petcarecenter/viewpets" class="btn-dashboard">View Pets</a>
                    </div>
                    <div class="card">
                        <h3>Maintain Cages</h3>
                        <p>Track and update the condition of cages.</p>
                        <a href="<?=ROOT?>/carecentercage" class="btn-dashboard">Maintain Cages</a>
                    </div>
                    <div class="card">
                        <h3>Update Availability</h3>
                        <p>Set available dates and times for accepting new pets.</p>
                        <a href="<?=ROOT?>/petcarecenter/availability" class="btn-dashboard">Update Availability</a>
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