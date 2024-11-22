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
            <?php 
            if (isset($petOwnerDetails) && !empty($petOWnerDetails)):

                // Access the first element of the $vetDetails array
                $petowner = $petOwnerDetails[0]; 
            ?>
            <div class="profile-content">
                    <div class="profile-picture-container">
                        <div class="profile-picture">
                            <img src="<?= ROOT ?>/assets/images/default-profile-picture.webp" alt="Profile Picture">
                        </div>
                        <a href="javascript:void(0)" id="editProfileBtn" class="edit-profile-btn">Edit profile details</a>

                    </div>

                    <div class="profile-details">
                        <h1>------------------------My Profile------------------------</h1>
                        <!-- Display vet's details -->
                        <div class="detail-line">
                            <div class="detail-label">Username</div>
                            <div class="colon">:</div>
                            <div class="detail-value"><?= htmlspecialchars(string: $petowner->username) ?></div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Email</div>
                            <div class="colon">:</div>
                            <div class="detail-value"><?= htmlspecialchars( $petowner->email) ?></div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">First Name</div>
                            <div class="colon">:</div>
                            <div class="detail-value"><?= htmlspecialchars( $petowner->f_name) ?></div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Last Name</div>
                            <div class="colon">:</div>
                            <div class="detail-value"><?= htmlspecialchars( $petowner->l_name) ?></div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Age</div>
                            <div class="colon">:</div>
                            <div class="detail-value"><?= htmlspecialchars( $petowner->age) ?></div>
                        </div>


                        <div class="detail-line">
                            <div class="detail-label">District</div>
                            <div class="colon">:</div>
                            <div class="detail-value"><?= htmlspecialchars( $petowner->district) ?></div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">City</div>
                            <div class="colon">:</div>
                            <div class="detail-value"><?= htmlspecialchars( $petowner->city) ?></div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Contact No</div>
                            <div class="colon">:</div>
                            <div class="detail-value"><?= htmlspecialchars( $petowner->contact_no) ?></div>
                        </div>

                       

                        <div class="delete-profile">
                        <button id="deleteProfileBtn" class="delete-btn">Delete Profile</button>
                    </div>
            
                    </div>
                    

            </div>   
            <?php else: ?>
                <p>No vet details found.</p>
            <?php endif; ?>
                <!-- Popup structure -->
                <div id="editProfilePopup" class="popup">
                    <form action="#" method="POST" class="update-form">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="<?= htmlspecialchars($vet->username) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="f_name">First Name:</label>
                            <input type="text" id="f_name" name="f_name" value="<?= htmlspecialchars($vet->f_name) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="l_name">Last Name:</label>
                            <input type="text" id="l_name" name="l_name" value="<?= htmlspecialchars($vet->l_name) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" id="age" name="age" value="<?= htmlspecialchars($vet->age) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="district">District:</label>
                            <input type="text" id="district" name="district" value="<?= htmlspecialchars($vet->district) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" value="<?= htmlspecialchars($vet->city) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_no">Contact No:</label>
                            <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($vet->contact_no) ?>" required>
                        </div>
                        
                        <button type="submit">Update</button>
                    </form>

                </div>

                <div id="deleteConfirmationPopup">
                    <div class="popup-content">
                        <h3>Are you sure you want to delete this profile?</h3>
                        <button id="confirmDeleteBtn" class="confirm-btn">Yes, Delete</button>
                        <button id="cancelDeleteBtn" class="cancel-btn">Cancel</button>
                    </div>
                </div>


                <script>
                    // JavaScript for Popup
                    document.addEventListener('DOMContentLoaded', () => {
                        const popup = document.getElementById('editProfilePopup');
                        const editBtn = document.getElementById('editProfileBtn');

                        editBtn.addEventListener('click', () => {
                            popup.style.display = 'flex';
                        });

                        window.addEventListener('click', (event) => {
                            if (event.target === popup) {
                                popup.style.display = 'none';
                            }
                        });
                    });
                    
                    document.addEventListener('DOMContentLoaded', () => {
                        const deleteBtn = document.getElementById('deleteProfileBtn');

                        deleteBtn.addEventListener('click', () => {
                            if (confirm('Are you sure you want to delete this profile?')) {
                                // Redirect to the delete route
                                window.location.href = "<?= ROOT ?>/vet/delete";
                            }
                        });
                    });
                </script>



        </div>

    </div>
    
    <?php include ('components/footer.php'); ?>
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->
   
</body>
</html>