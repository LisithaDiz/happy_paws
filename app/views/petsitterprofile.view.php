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
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petsitterprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Sitter Profile</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include ('components/sidebar3.php'); ?>

        <div class="booking-container">
            <?php if (isset($sitterDetails) && !empty($sitterDetails)): ?>
            <?php $sitter = $sitterDetails[0]; ?>
            <div class="center-profile-section">
                <div class="cover-image">
                    <img src="<?=ROOT?>/assets/images/cover1-min.jpg" alt="Sitter Cover Image" class="cover-image">
                </div>

                <div class="profile-header">
                    <div class="profile-image1">
                        <?php if (!empty($sitter->profile_image)): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($sitter->profile_image) ?>" 
                                alt="Sitter Profile Image" class="profile-image1">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Default Profile Image" class="profile-image1">
                        <?php endif; ?>
                    </div>
                    <div class="profile-info1">
                        <h1><?= htmlspecialchars($sitter->f_name) ?> <?= htmlspecialchars($sitter->l_name) ?></h1>
                        <?php if($_SESSION['user_role'] == 3): ?>
                            <button class="edit-profile-btn" id="editProfileBtn">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role'] == 1): ?>
                        <form method="POST" action="<?=ROOT?>/chatbox/index">
                                <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($sitter->user_id) ?>">
                                <input type="hidden" name="receiver_role_number" value="3" >
                                <button type="submit" class="message-btn">Message</button>
                        </form>
                        <?php endif; ?>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(30 reviews)</span>
                        </div>
                        <p class="location">
                            <i class="fas fa-map-marker-alt"></i> 
                            <?= htmlspecialchars($sitter->street) ?>,
                            <?= htmlspecialchars($sitter->city) ?>,
                            <?= htmlspecialchars($sitter->district) ?>
                            
                        </p>
                        <p class="contact"><i class="fas fa-phone"></i> <?= htmlspecialchars($sitter->contact_no) ?></p>
                        <p class="email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($sitter->email) ?></p>
                    </div>
                </div>

                <div class="profile-details">
                    <div class="detail-card">
                        <h3><i class="fas fa-paw"></i> Pet Sitting Details</h3>
                        <p><strong>Username:</strong> <?= htmlspecialchars($sitter->username) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($sitter->email) ?></p>
                        <p><strong>Age:</strong> <?= htmlspecialchars($sitter->age) ?></p>
                        <p><strong>Years of Experience:</strong> <?= htmlspecialchars($sitter->years_exp) ?></p>
                        <p><strong>Service Types:</strong> <?= htmlspecialchars($sitter->service_types ?? 'Pet Boarding, Home Visits') ?></p>
                    </div>

                    <div class="detail-card">
                        <h3><i class="fas fa-info-circle"></i> About Me</h3>
                        <p><?= !empty($sitter->about_us) ? htmlspecialchars($sitter->about_us) : 'Passionate pet sitter with '.htmlspecialchars($sitter->years_exp).' years of experience, providing loving care for pets in their owner’s absence.' ?></p>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-user"></i>
                    <p>No sitter details found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editProfileModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Edit Sitter Profile</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="<?= ROOT ?>/petsitterprofile/sitterProfileUpdate" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="sitter_id" value="<?= htmlspecialchars($sitter->sitter_id) ?>">

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($sitter->username) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="f_name">First Name</label>
                        <input type="text" id="f_name" name="f_name" value="<?= htmlspecialchars($sitter->f_name) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="l_name">Last Name</label>
                        <input type="text" id="l_name" name="l_name" value="<?= htmlspecialchars($sitter->l_name) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" value="<?= htmlspecialchars($sitter->age) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="M" <?= $sitter->gender == 'M' ? 'selected' : '' ?>>Male</option>
                            <option value="F" <?= $sitter->gender == 'F' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" name="district" value="<?= htmlspecialchars($sitter->district) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?= htmlspecialchars($sitter->city) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($sitter->contact_no) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="years_exp">Years of Experience</label>
                        <input type="number" id="years_exp" name="years_exp" value="<?= htmlspecialchars($sitter->years_exp) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="service_types">Service Types</label>
                        <input type="text" id="service_types" name="service_types" value="<?= htmlspecialchars($sitter->service_types ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="about_me">About Me</label>
                        <textarea id="about_me" name="about_me" rows="4"><?= htmlspecialchars($sitter->about_me ?? '') ?></textarea>
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
                window.location.href = "<?= ROOT ?>/PetSitterProfile/deleteSitter";
            });

            cancelDeleteBtn.addEventListener('click', function() {
                deleteConfirmationModal.classList.remove('active');
            });

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

