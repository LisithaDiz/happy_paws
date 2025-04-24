<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Vet Profile</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <?php include ('components/sidebar3.php'); ?>
        
        <div class="booking-container">
            <?php if (isset($vetDetails) && !empty($vetDetails)): ?>
            <?php $vet = $vetDetails[0]; ?>
            <div class="center-profile-section">
                <div class="cover-image">
                    <img src="<?=ROOT?>/assets/images/vet_cover3-min.jpg" alt="Vet Cover Image" class="cover-image">
                </div>

                <div class="profile-header">
                    <div class="profile-image1">
                        <?php if (!empty($vet->profile_image)): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($vet->profile_image) ?>" 
                                alt="Vet Profile Image" class="profile-image1">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Default Profile Image" class="profile-image1">
                        <?php endif; ?>
                    </div>
                    <div class="profile-info1">
                        <h1>Dr. <?= htmlspecialchars($vet->f_name) ?> <?= htmlspecialchars($vet->l_name) ?></h1>
                        <?php if($_SESSION['user_role'] == 2): ?>
                            <button class="edit-profile-btn" id="editProfileBtn">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role'] == 1): ?>
                        <!-- Message Button -->
                        <form method="POST" action="<?=ROOT?>/chatbox/index">
                                <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($vet->user_id) ?>">
                                <input type="hidden" name="receiver_role_number" value="2" >
                                <button type="submit" class="message-btn">Message</button>
                        </form>
                        <?php endif; ?>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(25 reviews)</span>
                        </div>
                        <p class="location">
                            <i class="fas fa-map-marker-alt"></i> 
                            <?= htmlspecialchars($vet->street) ?>,
                            <?= htmlspecialchars($vet->city) ?>,
                            <?= htmlspecialchars($vet->district) ?>
                        </p>
                        <p class="contact"><i class="fas fa-phone"></i> <?= htmlspecialchars($vet->contact_no) ?></p>
                        <p class="email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($vet->email) ?></p>
                    </div>
                </div>

                <div class="profile-details">
                    <div class="detail-card">
                        <h3><i class="fas fa-user-md"></i> Professional Information</h3>
                        <p><strong>License No:</strong> <?= htmlspecialchars($vet->license_no) ?></p>
                        <p><strong>Years of Experience:</strong> <?= htmlspecialchars($vet->years_exp) ?></p>
                        <p><strong>Consultation Fee:</strong> Rs. <?= htmlspecialchars($vet->consultation_fee) ?></p>
                        <p><strong>Specializations:</strong> General Practice, Surgery</p>
                    </div>
                    
                    <div class="detail-card">
                        <h3><i class="fas fa-info-circle"></i> About Me</h3>
                        <p><?= !empty($vet->about_us) ? htmlspecialchars($vet->about_us) : 'Dedicated veterinarian with '.htmlspecialchars($vet->years_exp).' years of experience providing exceptional care for pets. Committed to ensuring the health and well-being of all animals through compassionate service and medical expertise.' ?></p>
                    </div>
                    
                    
            </div>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-user-md"></i>
                    <p>No vet details found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editProfileModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Edit Vet Profile</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="<?= ROOT ?>/VetProfile/vetprofileUpdate" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="vet_id" value="<?= htmlspecialchars($vet->vet_id) ?>">
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($vet->username) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_name">First Name</label>
                        <input type="text" id="f_name" name="f_name" value="<?= htmlspecialchars($vet->f_name) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="l_name">Last Name</label>
                        <input type="text" id="l_name" name="l_name" value="<?= htmlspecialchars($vet->l_name) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="license_no">License Number</label>
                        <input type="text" id="license_no" name="license_no" value="<?= htmlspecialchars($vet->license_no) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" value="<?= htmlspecialchars($vet->age) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="M" <?= $vet->gender == 'M' ? 'selected' : '' ?>>Male</option>
                            <option value="F" <?= $vet->gender == 'F' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" name="district" value="<?= htmlspecialchars($vet->district) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?= htmlspecialchars($vet->city) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($vet->contact_no) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="years_exp">Years of Experience</label>
                        <input type="number" id="years_exp" name="years_exp" value="<?= htmlspecialchars($vet->years_exp) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="years_exp">Consultation Fee</label>
                        <input type="number" id="consultation_fee" name="consultation_fee" value="<?= htmlspecialchars($vet->consultation_fee) ?>" required>
                        <span id="consultationFeeError" class="error-message" style="color:red; font-size: 0.9em;"></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="about_us">About Me</label>
                        <textarea id="about_us" name="about_us" rows="4"><?= htmlspecialchars($vet->about_us ?? '') ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*">
                    </div>
                    
                    <button type="submit" class="submit-btn">Save Changes</button>
                    <button type="button" id="deleteProfileBtn" class="delete-btn">Delete Profile</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteConfirmationModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Confirm Deletion</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to permanently delete your profile? This action cannot be undone.</p>
                <div class="modal-actions">
                    <button id="confirmDeleteBtn" class="confirm-btn">Yes, Delete</button>
                    <button id="cancelDeleteBtn" class="cancel-btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit Profile Modal
            const editProfileBtn = document.getElementById('editProfileBtn');
            const editProfileModal = document.getElementById('editProfileModal');
            const closeEditModal = editProfileModal.querySelector('.close-modal');
            
            if (editProfileBtn) {
                editProfileBtn.addEventListener('click', function() {
                    editProfileModal.classList.add('active');
                });
            }
            
            closeEditModal.addEventListener('click', function() {
                editProfileModal.classList.remove('active');
            });
            
            // Delete Confirmation Modal
            const deleteProfileBtn = document.getElementById('deleteProfileBtn');
            const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            
            if (deleteProfileBtn) {
                deleteProfileBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    editProfileModal.classList.remove('active');
                    deleteConfirmationModal.classList.add('active');
                });
            }
            
            confirmDeleteBtn.addEventListener('click', function() {
                window.location.href = "<?= ROOT ?>/vetProfile/deleteVet";
            });
            
            cancelDeleteBtn.addEventListener('click', function() {
                deleteConfirmationModal.classList.remove('active');
            });
            
            // Close modals when clicking outside
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.remove('active');
                    }
                });
            });
        });

        document.getElementById('editProfileForm').addEventListener('submit', function(e) {
            const feeInput = document.getElementById('consultation_fee');
            const errorSpan = document.getElementById('consultationFeeError');
            const feeValue = parseFloat(feeInput.value);

            if (isNaN(feeValue) || feeValue <= 0) {
                e.preventDefault(); // stop form from submitting
                errorSpan.textContent = 'Consultation fee must be positive.';
                feeInput.focus();
            } else {
                errorSpan.textContent = '';
            }
        });

    </script>
    
    <?php include ('components/footer.php'); ?>
</body>
</html>