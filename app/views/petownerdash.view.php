<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
  
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <!-- <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar_.css"> -->
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Welcome!</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
       
        <?php include ('components/sidebar.php'); ?>
        <!-- Sidebar for pet owner functionalities -->

        <!-- Main content area -->
        <div class="main-content">
            <h1>Welcome, [Pet Owner's Name]!</h1>
            <p>We're glad to have you back. Your dashboard provides you with all the tools you need to manage pet records, find veterinary services, and more.</p>

            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Find Vet</h3>
                        <p>Search for veterinary services near you.</p>
                        <a href="<?=ROOT?>/findvet" class="btn-dashboard">Find Vet</a>
                    </div>
                    <div class="card">
                        <h3>Find Pet Guardians</h3>
                        <p>Connect with pet guardians in your area.</p>
                        <a href="<?=ROOT?>/findguardians" class="btn-dashboard">Find Guardians</a>
                    </div>
                    <div class="card">
                        <h3>Pharmacies</h3>
                        <p>Locate pharmacies for pet medications.</p>
                        <a href="<?=ROOT?>/pharmacies" class="btn-dashboard">Find Pharmacies</a>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="contact">
                <h2>Need Help?</h2>
                <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                <a href="<?=ROOT?>/contact" class="btn-dashboard">Contact Support</a>
            </section>
        </div>
    </div>
    
    <?php include ('components/footer.php'); ?>
    <!-- <script src="<?=ROOT?>/assets/js/script.js"></script> -->
</body>
</html>
