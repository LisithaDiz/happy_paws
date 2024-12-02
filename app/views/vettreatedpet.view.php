<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vettreatedpets.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Treated Pets</title>


</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar3.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <div class="overview-cards">
                    <h1>Treated Pets</h1>
                    
                    <!-- Prescription List -->
                    <div class="prescription-card" id="prescription1">
                        <div class="pet-info">
                            <img src="<?=ROOT?>/assets/images/background3.jpeg" alt="Buddy" class="pet-photo">
                            <div>
                                <h3>Buddy</h3>
                                <p>Age: 2 years</p>
                            </div>
                        </div>
                        <button class="btn-dashboard" >View Pet</button>
                    </div>

                    <div class="prescription-card" id="prescription2">
                        <div class="pet-info">
                            <img src="<?=ROOT?>/assets/images/background2.jpeg" alt="Bella" class="pet-photo">
                            <div>
                                <h3>Bella</h3>
                                <p>Age: 3 years</p>
                            </div>
                        </div>
                      <button class="btn-dashboard" >View Pet</button>

                    </div>
                </div>
            </div>
        </div>

        
        <?php include ('components/footer.php'); ?>
<!--    
        <script src="<?=ROOT?>/assets/js/script.js"></script> -->

    
</body>
</html>