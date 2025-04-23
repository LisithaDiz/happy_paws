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
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmacyprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Pharmacy Profile</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include ('components/sidebar3.php'); ?>

        <div class="booking-container">
            <?php if (isset($pharmacyDetails) && !empty($pharmacyDetails)): ?>
            <?php $pharmacy = $pharmacyDetails[0]; ?>
            <div class="center-profile-section">
                <div class="cover-image">
                    <img src="<?=ROOT?>/assets/images/cover1-min.jpg" alt="Pharmacy Cover Image" class="cover-image">
                </div>

                <div class="profile-header">
                    <div class="profile-image1">
                        <?php if (!empty($pharmacy->profile_image)): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($pharmacy->profile_image) ?>" alt="Pharmacy Profile Image" class="profile-image1">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Default Profile Image" class="profile-image1">
                        <?php endif; ?>
                    </div>
                    <div class="profile-info1">
                        <h1><?= htmlspecialchars($pharmacy->name) ?></h1>
                        <?php if($_SESSION['user_role'] == 5): ?>
                            <button class="edit-profile-btn" id="editProfileBtn">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role'] == 1): ?>
                        <form method="POST" action="<?=ROOT?>/chatbox/index">
                                <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($pharmacy->user_id) ?>">
                                <input type="hidden" name="receiver_role_number" value="3" >
                                <button type="submit" class="message-btn">Message</button>
                        </form>
                        <?php endif; ?>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="reviews">(50 reviews)</span>
                        </div>
                        <p class="location">
                            <i class="fas fa-map-marker-alt"></i> 
                            <?= htmlspecialchars($pharmacy->street) ?>,
                            <?= htmlspecialchars($pharmacy->city) ?>,
                            <?= htmlspecialchars($pharmacy->district) ?>
                        </p>
                        <p class="contact"><i class="fas fa-phone"></i> <?= htmlspecialchars($pharmacy->contact_no) ?></p>
                        <p class="email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($pharmacy->email) ?></p>
                    </div>
                </div>

                <div class="profile-details">
                    <div class="detail-card">
                        <h3><i class="fas fa-capsules"></i> Pharmacy Details</h3>
                        <p><strong>Pharmacy Name:</strong> <?= htmlspecialchars($pharmacy->name) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($pharmacy->email) ?></p>
                    </div>

                    <div class="detail-card">
                        <h3><i class="fas fa-info-circle"></i> About Us</h3>
                        <p><?= !empty($pharmacy->about_us) ? htmlspecialchars($pharmacy->about_us) : 'We provide a wide range of pharmaceuticals and pet care products.' ?></p>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="no-data">
                    <i class="fas fa-user"></i>
                    <p>No pharmacy details found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Profile Modal -->

    <div class="modal-overlay" id="editProfileModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Edit Pharmacy Profile</h3>
                <button class="close-modal">&times;</button>
            </div>

            
            <div class="modal-body">
                <form id="editProfileForm" action="<?= ROOT ?>/pharmacyprofile/pharmacyProfileUpdate" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="pharmacy_id" value="<?= htmlspecialchars($pharmacy->pharmacy_id) ?>">

                    <div class="form-group">
                        <label for="name">Pharmacy Name</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($pharmacy->name) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($pharmacy->email) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($pharmacy->contact_no) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" id="street" name="street" value="<?= htmlspecialchars($pharmacy->street) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?= htmlspecialchars($pharmacy->city) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" name="district" value="<?= htmlspecialchars($pharmacy->district) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="about_us">About Us</label>
                        <textarea id="about_us" name="about_us" rows="4"><?= htmlspecialchars($pharmacy->about_us ?? '') ?></textarea>
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
                window.location.href = "<?= ROOT ?>/PharmacyProfile/deletePharmacy";
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
</body>
</html>

