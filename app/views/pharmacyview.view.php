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
        <!-- include pet owner sidebar-->
            <ul>
                <li><a href="<?=ROOT?>/petsitterdash">Dashboard</a></li>
                <li><a href="<?=ROOT?>/petsitterprofile">My Profile</a></li>
                <!-- <li><a href="<?=ROOT?>/petsitterrequest">View Requests</a></li> -->
                <li><a href="<?=ROOT?>/petsitteraccepted">Upcoming Bookings</a></li>    
                <li><a href="<?=ROOT?>/petsitterpet">View Pets</a></li>
                <li><a href="<?=ROOT?>/petsitteravailability">Update Availability</a></li>
            </ul>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            
            <div class="profile-content">
                    <div class="profile-picture-container">
                        <div class="profile-picture">
                            <img src="<?= ROOT ?>/assets/images/default-profile-picture.webp" alt="Profile Picture">
                        </div>

                    </div>

                    <div class="profile-details">
                        <h1>My Profile</h1>
                        <!-- Display vet's details -->
                        <div class="detail-line">
                            <div class="detail-label">Username</div>
                            <div class="colon">:</div>
                            <div class="detail-value">remed</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Email</div>
                            <div class="colon">:</div>
                            <div class="detail-value">remed@gmail.com</div>
                        </div>

        

                        <div class="detail-line">
                            <div class="detail-label">Name</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Remed</div>
                        </div>


                        <div class="detail-line">
                            <div class="detail-label">District</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Gampaha</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">City</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Kadawatha</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Street</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Green Street</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Contact No</div>
                            <div class="colon">:</div>
                            <div class="detail-value">0759753211</div>
                        </div>


                        <div class="delete-profile">
                        <button id="deleteProfileBtn" class="delete-btn">Request Medicine</button>
                    </div>
            
                    </div>
                    

            </div>   
            
            
        </div>

    </div>
    
    <?php include ('components/footer.php'); ?>
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->
   
</body>
</html>