<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petsitterdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <title>Happy Paws - My Dashboard</title>

    
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar_pet_sitter.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
        <h1>Welcome, [Pet Sitter Name]!</h1>
        <p>We're excited to have you back. Your dashboard is your go-to place to manage pet care requests, track accepted bookings, update your availability, and provide top-notch care for pets in need.</p>


            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Accepted Requests</h3>
                        <p>3 accepted Requests</p>
                        <a href="<?=ROOT?>/vetappoinment" class="btn-dashboard">Accepted requests</a>
                    </div>
                    <div class="card">
                        <h3>View Requests</h3>
                        <p>6 Requests received</p>
                        <a href="<?=ROOT?>/vetrequest" class="btn-dashboard">Received requests</a>
                    </div>
                    <div class="card">
                        <h3>Update Availability</h3>
                        <p>Update Available Dates & Times</p>
                        <a href="<?=ROOT?>/vetprescription" class="btn-dashboard">Update</a>
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
    
    <?php include ('components/footer_mini.php'); ?>
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->
   
</body>
</html>