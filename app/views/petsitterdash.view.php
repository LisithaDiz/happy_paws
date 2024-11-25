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
                <li><a href="<?=ROOT?>/petsitterdash">Dashboard</a></li>
                <li><a href="<?=ROOT?>/petsitterprofile">My Profile</a></li>
                <!-- <li><a href="<?=ROOT?>/petsitterrequest">View Requests</a></li> -->
                <li><a href="<?=ROOT?>/petsitteraccepted">Upcoming Bookings</a></li>    
                <li><a href="<?=ROOT?>/petsitterpet">View Pets</a></li>
                <li><a href="<?=ROOT?>/petsitteravailability">Update Availability</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
        <h1>Welcome, [Pet Sitter Name]!</h1>
        <p>We're excited to have you back. Your dashboard is your go-to place to manage pet care requests, track accepted bookings, update your availability, and provide top-notch care for pets in need.</p>


            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Upcoming Bookings</h3>
                        <p>5 Upcoming bookings</p>
                        <a href="<?=ROOT?>/petsitteraccepted" class="btn-dashboard">Accepted requests</a>
                    </div>
                    <div class="card">
                        <h3>View Pets</h3>
                        <p>Check all pets currently at your center.</p>
                        <a href="<?=ROOT?>/petsitterpet" class="btn-dashboard">View Pets</a>
                    </div>
                    
                    <div class="card">
                        <h3>Update Availability</h3>
                        <p>Update Available Dates & Times</p>
                        <a href="<?=ROOT?>/petsitteravailability" class="btn-dashboard">Update</a>
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