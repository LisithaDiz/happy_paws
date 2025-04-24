<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petowner_profile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Happy Paws - My Profile</title>


</head>
<body>
    <?php include('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for pet owner functionalities -->
        <?php include ('components/sidebar_pet_owner.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <div class="profile-picture">
                <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Profile Picture">
            </div>

            <div class="profile-details">
                <h1>My Profile</h1>
                <br/>

                <div class="detail-line">
                    <div class="detail-label">Username</div>
                    <div class="colon">:</div>
                    <div class="detail-value">naveenNimasara</div> 
                </div>
                
                <div class="detail-line">
                    <div class="detail-label">Email</div>
                    <div class="colon">:</div>
                    <div class="detail-value">naveen@example.com</div> 
                </div>
                
                <div class="detail-line">
                    <div class="detail-label">Password</div>
                    <div class="colon">:</div>
                    <div class="detail-value">********</div> 
                </div>

                <div class="detail-line">
                    <div class="detail-label">Created Date</div>
                    <div class="colon">:</div>
                    <div class="detail-value">2024-11-12</div> 
                </div>

                <div class="detail-line">
                    <div class="detail-label">First Name</div>
                    <div class="colon">:</div>
                    <div class="detail-value">Naveen</div> 
                </div>

                <div class="detail-line">
                    <div class="detail-label">Last Name</div>
                    <div class="colon">:</div>
                    <div class="detail-value">Nimsara</div> 
                </div>

                <div class="detail-line">
                    <div class="detail-label">Age</div>
                    <div class="colon">:</div>
                    <div class="detail-value">35</div> 
                </div>

                <div class="detail-line">
                    <div class="detail-label">Gender</div>
                    <div class="colon">:</div>
                    <div class="detail-value">Male</div>
                </div>

                <div class="detail-line">
                    <div class="detail-label">District</div>
                    <div class="colon">:</div>
                    <div class="detail-value">Colombo</div>
                </div>

                <div class="detail-line">
                    <div class="detail-label">City</div>
                    <div class="colon">:</div>
                    <div class="detail-value">Panadura</div>
                </div>

                <div class="detail-line">
                    <div class="detail-label">Contact No</div>
                    <div class="colon">:</div>
                    <div class="detail-value">+07777777</div> 
                </div>
                
                <div class="detail-line">
                    <div class="detail-label">Number of Pets</div>
                    <div class="colon">:</div>
                    <div class="detail-value">3</div> 
                </div>
            </div>
        </div>
    </div>
    
    <?php include('components/footer_mini.php'); ?>
   
    <script src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>
