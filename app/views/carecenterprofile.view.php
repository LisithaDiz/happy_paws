<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecenterprofile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Book Pet Care Services</title>
</head>
<body>
    <?php if (!isset($petCareCenter)) {
        echo "<p>Error: Care center information not available.</p>";
        return;
    } ?>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <?php if($_SESSION['user_role'] == 4){
            include ('components/sidebar_care_center.php');
        }else{
            include ('components/sidebar.php');
        } ?>
        
        <div class="booking-container">
            <div class="center-profile-section">
                <div class="cover-image">
                    <?php if (!empty($petCareCenter[0]->cover_image)): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($petCareCenter[0]->cover_image) ?>" 
                            alt="<?= htmlspecialchars($petCareCenter[0]->name) ?>" class="cover-image">
                    <?php else: ?>
                        <img src="<?=ROOT?>/assets/images/cover1.jpg" alt="<?= htmlspecialchars($petCareCenter[0]->name) ?>" class="cover-image">
                    <?php endif; ?>
                </div>

                <div class="profile-header">
                    <div class="profile-image1">
                        <?php if (!empty($petCareCenter[0]->profile_image)): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($petCareCenter[0]->profile_image) ?>" 
                                alt="<?= htmlspecialchars($petCareCenter[0]->name) ?>" class="profile-image1">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/profile1.jpg" alt="<?= htmlspecialchars($petCareCenter[0]->name) ?>" class="profile-image">
                        <?php endif; ?>
                    </div>
                    <div class="profile-info1">
                            <h1><?= htmlspecialchars($petCareCenter[0]->name ?? 'Unknown Care Center') ?></h1>
                        <?php if($_SESSION['user_role'] == 4): ?>
                            <button class="edit-profile-btn" id="editProfileBtn">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                        <?php endif; ?>
                        <div class="rating">
                            <span class="stars"><?= str_repeat("★", $petCareCenter[0]->rating ?? 0) ?></span>
                            <span class="reviews">(<?= $petCareCenter[0]->review_count ?? 0 ?> reviews)</span>
                        </div>
                        <p class="location">
                            <i class="fas fa-map-marker-alt"></i> 
                            <?= htmlspecialchars($petCareCenter[0]->street ?? '') ?>, 
                            <?= htmlspecialchars($petCareCenter[0]->city ?? '') ?>, 
                            <?= htmlspecialchars($petCareCenter[0]->district ?? '') ?>
                        </p>
                        <p class="contact"><i class="fas fa-phone"></i> <?= htmlspecialchars($petCareCenter[0]->contact_no ?? 'Not provided') ?></p>
                        <p class="email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($petCareCenter[0]->email ?? 'Not provided') ?></p>
                    </div>
                </div>

                <div class="profile-details">
                    <div class="detail-card">
                        <h3><i class="fas fa-info-circle"></i> About Us</h3>
                        <p><?= htmlspecialchars($petCareCenter[0]->about_us ?? 'No description available') ?></p>
                    </div>
                    
                    <div class="detail-card">
                        <h3><i class="fas fa-concierge-bell"></i> Services Offered</h3>
                        <p><?= htmlspecialchars($petCareCenter[0]->services_offered ?? 'Not specified') ?></p>
                    </div>
                    
                    <div class="detail-card">
                        <h3><i class="fas fa-clock"></i> Business Hours</h3>
                        <p><?= htmlspecialchars($petCareCenter[0]->openning_hours ?? 'Not specified') ?></p>
                    </div>
                </div>
            </div>

            <div class="cage-booking-section">
                <h2>Available Cages</h2>
                
                <?php if (!empty($cages) && is_array($cages)): ?>
                    <div class="cage-grid">
                        <?php foreach ($cages as $cage): ?>
                            <div class="cage-card">
                                <div class="cage-image">
                                    <img src="data:image/jpeg;base64,<?= base64_encode($cage->cage_img) ?>" alt="<?= htmlspecialchars($cage->cage_name) ?>">
                                    <span class="availability-badge <?= $cage->available_cages > 0 ? 'available' : 'unavailable' ?>">
                                        <?= $cage->available_cages > 0 ? 'Available' : 'Booked Out' ?>
                                    </span>
                                </div>
                                
                                <div class="cage-info">
                                    <h3><?= htmlspecialchars($cage->cage_name) ?></h3>
                                    <div class="specs">
                                        <p><i class="fas fa-paw"></i> Designed for: <?= htmlspecialchars($cage->designed_for) ?></p>
                                        <p><i class="fas fa-ruler-combined"></i> Dimensions: <?= htmlspecialchars($cage->height) ?> x <?= htmlspecialchars($cage->length) ?> x <?= htmlspecialchars($cage->width) ?></p>
                                        <p><i class="fas fa-home"></i> Location: <?= htmlspecialchars($cage->location) ?></p>
                                        <p><i class="fas fa-clipboard-list"></i> Features: <?= htmlspecialchars($cage->additional_features) ?></p>
                                    </div>
                                    
                                    <div class="booking-info">
                                        <div class="availability">
                                            <span class="count"><?= htmlspecialchars($cage->available_cages) ?></span>
                                            <span class="label">available</span>
                                            <span class="total">of <?= htmlspecialchars($cage->number_of_cages) ?></span>
                                        </div>
                                        
                                        <button class="book-btn <?= $cage->available_cages > 0 ? '' : 'disabled' ?>" 
                                                data-cage-id="<?= htmlspecialchars($cage->cage_id) ?>"
                                                data-cage-type="<?= htmlspecialchars($cage->designed_for)?>">
                                            <i class="fas fa-calendar-check"></i> Book Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-cages">
                        <i class="fas fa-box-open"></i>
                        <p>No cages currently available at this center.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Booking Modal -->
    <div class="modal-overlay" id="bookingModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Book Cage</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="<?= ROOT ?>/petOwnerController/addBookings" method="POST">
                    <input type="hidden" id="cageId" name="cage_id">
                    <input type="hidden" id="carecenter_id" name="carecenter_id" value="<?= htmlspecialchars($petCareCenter[0]->care_center_id) ?>">
                    
                    <div class="form-group">
                        <label for="petSelect">Select Pet</label>
                        <select id="petSelect" name="pet_id" required>
                            <option value="">-- Select Pet --</option>
                            <!-- Populated by JavaScript -->
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="checkinDate">Check-in Date</label>
                        <input type="date" id="checkinDate" name="checkin_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="checkoutDate">Check-out Date</label>
                        <input type="date" id="checkoutDate" name="checkout_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="specialRequests">Special Requests</label>
                        <textarea id="specialRequests" name="special_requests" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" class="submit-booking">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editProfileModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3>Edit Care Center Profile</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="<?= ROOT ?>/CareCenterProfile/updateProfile" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="care_center_id" value="<?= htmlspecialchars($petCareCenter[0]->care_center_id) ?>">
                    
                    <div class="form-group">
                        <label for="name">Care Center Name</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($petCareCenter[0]->name) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" name="district" value="<?= htmlspecialchars($petCareCenter[0]->district) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?= htmlspecialchars($petCareCenter[0]->city) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" id="street" name="street" value="<?= htmlspecialchars($petCareCenter[0]->street) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($petCareCenter[0]->contact_no) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="opening_hours">Opening Hours</label>
                        <input type="text" id="opening_hours" name="opening_hours" value="<?= htmlspecialchars($petCareCenter[0]->opening_hours) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="services_offered">Services Offered</label>
                        <textarea id="services_offered" name="services_offered" rows="3" required><?= htmlspecialchars($petCareCenter[0]->services_offered) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="about_us">About Us</label>
                        <textarea id="about_us" name="about_us" rows="3" required><?= htmlspecialchars($petCareCenter[0]->about_us) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*">
                    </div>
                    
                    <div class="form-group">
                        <label for="cover_image">Cover Image</label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*">
                    </div>
                    
                    <button type="submit" class="submit-btn">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Book button click handlers
        const bookButtons = document.querySelectorAll('.book-btn:not(.disabled)');
        const modal = document.getElementById('bookingModal');
        const closeModal = document.querySelector('.close-modal');
        // const bookingForm = document.getElementById('bookingForm');
        const cageIdInput = document.getElementById('cageId');
        
        // Open modal when book button is clicked
        bookButtons.forEach(button => {
            button.addEventListener('click', function() {
    
                const cageType = this.getAttribute('data-cage-type');

            
                petSelect.innerHTML = '<option value="">-- Select Pet --</option>';
                
                // Get pets data from PHP and ensure it's an array
                const petsData = <?php echo is_array($data['pets']) ? json_encode($data['pets']) : '[]'; ?>;
                
                // Check if pets data exists and is an array
                if (Array.isArray(petsData) && petsData.length > 0) {
                    // Filter pets based on cage type
                    const filteredPets = petsData.filter(pet => {
                        return pet.pet_type.toLowerCase()+"s" === cageType.toLowerCase();
                    });
                    
                    console.log('Filtered pets:', filteredPets);
                    
                    if (filteredPets.length > 0) {
                        // Add filtered pets to select
                        filteredPets.forEach(pet => {
                            const option = document.createElement('option');
                            option.value = pet.pet_id;
                            option.textContent = `${pet.pet_name} (${pet.pet_type})`;
                            petSelect.appendChild(option);
                        });
                    } else {
                        petSelect.innerHTML += '<option value="" disabled>No pets of type ' + cageType + ' found</option>';
                    }
                } else {
                    petSelect.innerHTML += '<option value="" disabled>No pets available</option>';
                }
                
                // Set minimum date for check-in (today)
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('checkinDate').min = today;
                
                modal.classList.add('active');
            });
        });
        
        // Close modal
        closeModal.addEventListener('click', function() {
            modal.classList.remove('active');
        });
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
        
        // Update checkout date minimum based on checkin date
            document.getElementById('checkinDate').addEventListener('change', function() {
                document.getElementById('checkoutDate').min = this.value;
            });
        });
        
        // Edit Profile Modal functionality
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
        
        editProfileModal.addEventListener('click', function(e) {
            if (e.target === editProfileModal) {
                editProfileModal.classList.remove('active');
            }
        });
        
        // Handle form submission
        const editProfileForm = document.getElementById('editProfileForm');
        if (editProfileForm) {
            editProfileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile updated successfully!');
                        window.location.reload();
                    } else {
                        alert('Error updating profile: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the profile.');
                });
            });
        }
    </script>
</body>
</html>
