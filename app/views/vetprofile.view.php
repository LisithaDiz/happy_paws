<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetprofile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/sidebar.css">

</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php
        include 'components/renderSidebar.php'; 

        echo renderSidebar(ROOT, $vet);
        ?>

        <!-- Main content area -->
        <div class="main-content">
            

            <div class="profile-picture">
                <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Profile Picture">
            </div>

            <div class="profile-details">
                <h1>-------------------------------Vet Profile-------------------------------</h1>
                <br/>

                <div class="detail-line">
                    <div class="detail-label">Username</div>
                    <div class="colon">:</div>
                    <div class="detail-value">johndoe</div> 
                </div>
                
                <div class="detail-line">
                    <div class="detail-label">Email</div>
                    <div class="colon">:</div>
                    <div class="detail-value">johndoe@example.com</div> 
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
                    <div class="detail-label">License No</div>
                    <div class="colon">:</div>
                    <div class="detail-value">123456</div> 
                </div>

                <div class="detail-line">
                    <div class="detail-label">First Name</div>
                    <div class="colon">:</div>
                    <div class="detail-value">John</div> 
                </div>

                <div class="detail-line">
                    <div class="detail-label">Last Name</div>
                    <div class="colon">:</div>
                    <div class="detail-value">Doe</div> 
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
                    <div class="detail-value">Downtown</div>
                </div>

                <div class="detail-line">
                    <div class="detail-label">City</div>
                    <div class="colon">:</div>
                    <div class="detail-value">Metropolis</div>
                </div>

                <div class="detail-line">
                    <div class="detail-label">Contact No</div>
                    <div class="colon">:</div>
                    <div class="detail-value">+123456789</div> 
                </div>

                <div class="detail-line">
                    <div class="detail-label">Years of Experience</div>
                    <div class="colon">:</div>
                    <div class="detail-value">10</div> 
                </div>
               
                
            </div>

            </div>

        </div>

    </div>
    
    <?php include ('components/footer.php'); ?>
   
    <script src="<?=ROOT?>/assets/js/script.js"></script>
   
</body>
</html>