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
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petownerprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Vet Profile</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <?php include ('components/sidebar.php'); ?>
        
        <div class="booking-container">
            <?php if (isset($ownerDetails) && !empty($ownerDetails)): ?>
            <?php $owner = $ownerDetails[0]; ?>
            <div class="center-profile-section">
                <div class="cover-image">
                    <img src="<?=ROOT?>/assets/images/vet_cover3-min.jpg" alt="Vet Cover Image" class="cover-image">
                </div>

                <div class="profile-header">
                    <div class="profile-image1">
                        <?php if (!empty($owner->profile_image)): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($owner->profile_image) ?>" 
                                alt="Owner Profile Image" class="profile-image1">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Default Profile Image" class="profile-image1">
                        <?php endif; ?>
                    </div>
                    <div class="profile-info1">
                        <h1><?= htmlspecialchars($owner->f_name) ?> <?= htmlspecialchars($owner->l_name) ?></h1>
                        <?php if($_SESSION['user_role'] == 1): ?>
                            <button class="edit-profile-btn" id="editProfileBtn">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role'] == 2 || $_SESSION['user_role'] == 3 || $_SESSION['user_role'] == 4 || $_SESSION['user_role'] == 5): ?>
                        <!-- Message Button -->
                        <form method="POST" action="<?=ROOT?>/chatbox/index">
                                <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($owner->user_id) ?>">
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
                            <?= htmlspecialchars($owner->street) ?>,
                            <?= htmlspecialchars($owner->city) ?>,
                            <?= htmlspecialchars($owner->district) ?>
                        </p>
                        <p class="contact"><i class="fas fa-phone"></i> <?= htmlspecialchars($owner->contact_no) ?></p>
                        <p class="email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($owner->email) ?></p>
                    </div>
                </div>

                <div class="profile-details">
                    <div class="detail-card">
                        <h3><i class="fas fa-user-md"></i> Personal Information</h3>
                        <p><strong>Username:</strong> <?= htmlspecialchars($owner->username) ?></p>
                        <p><strong>Age:</strong> <?= htmlspecialchars($owner->age) ?></p>
                        
                    </div>
                    <div class="detail-card">
                        <h3><i class="fas fa-dog"></i> My Pets</h3>
                        <div class="pet-cards">
                            <?php if(!empty($petDetails)): ?>
                                <?php foreach($petDetails as $pet): ?>
                                    <form method="POST" action="<?=ROOT?>/petprofile/index" class="pet-form">
                                        <input type="hidden" name="pet_id" value="<?=htmlspecialchars($pet->pet_id) ?>">
                                        <button type="submit" class="pet-card">
                                        
                                            <?php if (!empty($pet->profile_image)): ?>
                                                <img src="data:image/jpeg;base64,<?= base64_encode($pet->profile_image) ?>" 
                                                    alt="Owner Profile Image" class="profile-image1">
                                            <?php else: ?>
                                                <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Default Profile Image" class="profile-image1">
                                            <?php endif; ?>
                                        
                                            <div class="pet-card-content">
                                                <h3><?= htmlspecialchars($pet->pet_name) ?></h3>
                                                <p><?= htmlspecialchars($pet->pet_type) ?></p>
                                                <p>Breed: <?= htmlspecialchars($pet->breed) ?></p>
                                                <p>Age: <?= htmlspecialchars($pet->age) ?> Years</p>
                                            </div>
                                        </button>
                                    </form>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No pets found for this owner.</p>
                            <?php endif; ?>
                        </div>
                        
                        
                    </div>
                    
                    
            </div>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-user-md"></i>
                    <p>No owner details found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editProfileModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Edit Profile</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="<?= ROOT ?>/PetOwnerProfile/ownerprofileUpdate" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="vet_id" value="<?= htmlspecialchars($owner->owner_id) ?>">
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($owner->username) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="f_name">First Name</label>
                        <input type="text" id="f_name" name="f_name" value="<?= htmlspecialchars($owner->f_name) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="l_name">Last Name</label>
                        <input type="text" id="l_name" name="l_name" value="<?= htmlspecialchars($owner->l_name) ?>" required>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" value="<?= htmlspecialchars($owner->age) ?>" required>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" name="district" value="<?= htmlspecialchars($owner->district) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?= htmlspecialchars($owner->city) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($owner->contact_no) ?>" required>
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
                window.location.href = "<?= ROOT ?>/PetOwnerProfile/deleteOwner";
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
    </script>
    
    <?php include ('components/footer.php'); ?>
</body>
</html>
