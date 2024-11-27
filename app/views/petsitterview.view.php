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
                            <div class="detail-value">DasunPerea</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Email</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Dasun@gmail.com</div>
                        </div>

        

                        <div class="detail-line">
                            <div class="detail-label">First Name</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Dasun</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Last Name</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Perera</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Age</div>
                            <div class="colon">:</div>
                            <div class="detail-value">22</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Gender</div>
                            <div class="colon">:</div>
                            <div class="detail-value">M</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">District</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Kaluthara</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">City</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Wadduwa</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Street</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Wijaya Street</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Contact No</div>
                            <div class="colon">:</div>
                            <div class="detail-value">0759883211</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Years of Experience</div>
                            <div class="colon">:</div>
                            <div class="detail-value">4</div>
                        </div>

                        <div class="delete-profile">
                        <button id="deleteProfileBtn" class="delete-btn">Book Pet Sitter</button>
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