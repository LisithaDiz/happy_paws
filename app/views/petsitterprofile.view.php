<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetprofile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">

</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <div class="sidebar">
            <ul>
            <li><a href="<?=ROOT?>/PetSitterDashboard">Dashboard</a></li>
                <li><a href="<?=ROOT?>/PetSitterProfile">My Profile</a></li>
                <li><a href="<?=ROOT?>/PetSitterRequest">View Requests</a></li>
                <li><a href="<?=ROOT?>/PetSitterAccepted">Accepted Requests</a></li>    
                <li><a href="<?=ROOT?>/PetSitterPet">View Pets</a></li>
                <li><a href="<?=ROOT?>/PetSitterAvailability">Update Availability</a></li>
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
                        <a href="javascript:void(0)" id="editProfileBtn" class="edit-profile-btn">Edit profile details</a>

                    </div>

                    <div class="profile-details">
                        <h1>My Profile</h1>
                        <!-- Display vet's details -->
                        <div class="detail-line">
                            <div class="detail-label">Username</div>
                            <div class="colon">:</div>
                            <div class="detail-value">KasunJayasinghe</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Email</div>
                            <div class="colon">:</div>
                            <div class="detail-value">kasun@gmail.com</div>
                        </div>

        

                        <div class="detail-line">
                            <div class="detail-label">First Name</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Kasun</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Last Name</div>
                            <div class="colon">:</div>
                            <div class="detail-value">Jayasinghe</div>
                        </div>

                        <div class="detail-line">
                            <div class="detail-label">Age</div>
                            <div class="colon">:</div>
                            <div class="detail-value">32</div>
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
                            <div class="detail-value">2</div>
                        </div>

                        <div class="delete-profile">
                        <button id="deleteProfileBtn" class="delete-btn">Delete Profile</button>
                    </div>
            
                    </div>
                    

            </div>   
            
                <!-- Popup structure -->
                <div id="editProfilePopup" class="popup">
                    <form action="" method="POST" class="update-form">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="KasunJayasinghe" required>
                        </div>
                        <div class="form-group">
                            <label for="f_name">First Name:</label>
                            <input type="text" id="f_name" name="f_name" value="Kasun" required>
                        </div>
                        <div class="form-group">
                            <label for="l_name">Last Name:</label>
                            <input type="text" id="l_name" name="l_name" value="Jayasinghe" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" id="age" name="age" value="32" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" required>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="district">District:</label>
                            <input type="text" id="district" name="district" value="Kaluthara" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" value="Wadduwa" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_no">Contact No:</label>
                            <input type="text" id="contact_no" name="contact_no" value="0759883211" required>
                        </div>
                        <div class="form-group">
                            <label for="years_exp">Years of Experience:</label>
                            <input type="number" id="years_exp" name="years_exp" value="2" required>
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