<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vettreatedpets.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">

    

</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <div class="sidebar">
            <ul>
                <li><a href="<?=ROOT?>/vetdash">Dashboard</a></li>
                <li><a href="<?=ROOT?>/vetprofile">My Profile</a></li>
                <li><a href="<?=ROOT?>/vetappoinment">Upcoming Appointments</a></li>
                <li><a href="<?=ROOT?>/vetrequest">Appointment Requests</a></li>    
                <li><a href="<?=ROOT?>/vettreatedpet">View Pets</a></li>
                <li><a href="<?=ROOT?>/vetprescription">Prescriptions</a></li>
                <li><a href="<?=ROOT?>/vet/settings">Settings</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <div class="overview-cards">
                    <h1>-----------------------------------Treated Pets-----------------------------------</h1>
                    
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
   
        <script src="<?=ROOT?>/assets/js/script.js"></script>

       


    
   
</body>
</html>