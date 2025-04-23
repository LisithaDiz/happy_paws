<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php if ($_SESSION['user_role'] == 4){
        echo "<title>Happy Paws - My Profile</title>";
    }elseif($_SESSION['user_role'] == 1){
        echo "<title>Happy Paws - CareCenter Profiles</title>";
    }else{
        echo "<title>Happy Paws</title>";
    } ?>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecenterprofile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Book Pet Care Services</title>
    <style>
        /* Additional styles for the demo calendar */
        .demo-calendar {
            margin-top: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
        }
        
        .demo-calendar h4 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #d8544c;
            font-size: 16px;
        }
        
        .demo-calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .demo-calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            border-radius: 3px;
            background-color: #f0f0f0;
        }
        
        .demo-calendar-day.available {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        
        .demo-calendar-day.unavailable {
            background-color: #F44336;
            color: white;
            cursor: not-allowed;
        }
        
        .demo-calendar-day-header {
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            color: #777;
            padding: 5px 0;
        }
        
        /* Manual date input styles */
        .manual-date-input {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        
        .manual-date-input h4 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #d8544c;
            font-size: 16px;
        }
        
        .date-input-group {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .date-input-group input[type="date"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            flex: 1;
        }
        
        .date-input-group button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .date-input-group button:hover {
            background-color: #45a049;
        }
        
        .manual-dates-list {
            margin-top: 10px;
        }
        
        .manual-dates-list p {
            background-color: #f0f0f0;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
        }
        
        .manual-dates-list p button {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 3px;
            padding: 2px 6px;
            cursor: pointer;
        }
        
        .calendar-container {
            margin: 20px 0;
        }
        
        .calendar-legend {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 3px;
        }
        
        .legend-color.available {
            background-color: #4CAF50;
        }
        
        .legend-color.unavailable {
            background-color: #F44336;
        }
        
        .legend-color.selected {
            background-color: #2196F3;
        }
        
        .availability-calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 10px;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .calendar-day.available {
            background-color: #E8F5E9;
            color: #2E7D32;
        }
        
        .calendar-day.unavailable {
            background-color: #FFEBEE;
            color: #C62828;
            cursor: not-allowed;
        }
        
        .calendar-day.selected {
            background-color: #E3F2FD;
            color: #1565C0;
        }
        
        .calendar-day:hover:not(.unavailable) {
            transform: scale(1.05);
        }
    </style>
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
            include ('components/sidebar_pet_owner.php');
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
                                        <h4><i class="fa-solid fa-dollar-sign"></i> Daily Price: <?= htmlspecialchars($cage->daily_price) ?></h4>
                                    </div>
                                    
                                    <div class="booking-info">
                                        <div class="availability">
                                            <span class="count"><?= htmlspecialchars($cage->available_cages) ?></span>
                                            <span class="label">available</span>
                                            <span class="total">of <?= htmlspecialchars($cage->number_of_cages) ?></span>
                                        </div>
                                        
                                        <button class="book-btn <?= $cage->available_cages > 0 ? '' : 'disabled' ?>" 
                                                data-cage-id="<?= htmlspecialchars($cage->cage_id) ?>"
                                                data-cage-type="<?= htmlspecialchars($cage->designed_for)?>"
                                                data-price="<?= htmlspecialchars($cage->daily_price) ?>">
                                                
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
                <form id="bookingForm" action="<?= ROOT ?>/CareCenterBookings/createBooking" method="POST">
                    <input type="hidden" id="cage_id" name="cage_id">
                    <input type="hidden" id="carecenter_id" name="carecenter_id" value="<?= htmlspecialchars($petCareCenter[0]->care_center_id) ?>">
                    
                    <div class="form-group">
                        <label for="petSelect">Select Pet</label>
                        <select id="petSelect" name="pet_id" required>
                            <option value="">-- Select Pet --</option>
                        </select>
                    </div>
                    
                    <div class="calendar-container">
                        <h4>Select Available Dates</h4>
                        <div class="calendar-legend">
                            <div class="legend-item">
                                <span class="legend-color available"></span>
                                <span>Available</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color unavailable"></span>
                                <span>Unavailable</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color selected"></span>
                                <span>Selected</span>
                            </div>
                        </div>
                        <div id="availabilityCalendar" class="availability-calendar">
                            <!-- Calendar will be populated by JavaScript -->
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="specialReq">Special Requirements (Optional)</label>
                        <textarea id="specialReq" name="special_req" rows="3" placeholder="Any special requirements for your pet's stay..."></textarea>
                    </div>
                    
                    <button type="submit" class="submit-booking">Book Selected Dates</button>
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
            const bookButtons = document.querySelectorAll('.book-btn:not(.disabled)');
            const modal = document.getElementById('bookingModal');
            const closeModal = document.querySelector('.close-modal');
            const cageIdInput = document.getElementById('cage_id');
            const petSelect = document.getElementById('petSelect');
            const availabilityCalendar = document.getElementById('availabilityCalendar');
            const bookingForm = document.getElementById('bookingForm');
            
            let selectedDates = new Set();
            
            // Open modal when book button is clicked
            bookButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const cageId = this.getAttribute('data-cage-id');
                    cageIdInput.value = cageId;
                    
                    const cageType = this.getAttribute('data-cage-type');
                    
                    // Reset selected dates
                    selectedDates.clear();
                    
                    // Populate pet select
                    populatePetSelect(cageType);
                    
                    // Fetch and render availability calendar
                    fetchAvailabilityCalendar(cageId);
                    
                    modal.classList.add('active');
                });
            });
            
            // Handle form submission
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Create hidden input for selected dates
                const datesInput = document.createElement('input');
                datesInput.type = 'hidden';
                datesInput.name = 'booking_dates';
                datesInput.value = JSON.stringify(Array.from(selectedDates));
                
                // Add the dates input to the form
                this.appendChild(datesInput);
                
                // Submit the form
                this.submit();
            });
            
            //pet showing in the booking modal
            function populatePetSelect(cageType) {
                petSelect.innerHTML = '<option value="">-- Select Pet --</option>';
                const petsData = <?php echo is_array($data['pets']) ? json_encode($data['pets']) : '[]'; ?>;
                
                if (Array.isArray(petsData) && petsData.length > 0) {
                    const filteredPets = petsData.filter(pet => {
                        return pet.pet_type.toLowerCase()+"s" === cageType.toLowerCase();
                    });
                    
                    if (filteredPets.length > 0) {
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
            }
            
            //fetching availability calendar
            function fetchAvailabilityCalendar(cageId) {
                const careCenterId = document.getElementById('carecenter_id').value;
                
                fetch('<?= ROOT ?>/CareCenterProfile/getCageAvailability', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `cage_id=${cageId}&care_center_id=${careCenterId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderAvailabilityCalendar(data.dates);
                    } else {
                        showError('Failed to fetch availability data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Failed to fetch availability data');
                });
            }
            
            function renderAvailabilityCalendar(dates) {
                availabilityCalendar.innerHTML = '';
                
                // Group dates by month
                const months = {};
                dates.forEach(date => {
                    const monthYear = new Date(date.date).toLocaleString('default', { month: 'long', year: 'numeric' });
                    if (!months[monthYear]) {
                        months[monthYear] = [];
                    }
                    months[monthYear].push(date);
                });
                
                // Render each month
                Object.entries(months).forEach(([monthYear, monthDates]) => {
                    const monthContainer = document.createElement('div');
                    monthContainer.className = 'calendar-month';
                    
                    const monthHeader = document.createElement('h5');
                    monthHeader.textContent = monthYear;
                    monthContainer.appendChild(monthHeader);
                    
                    const daysHeader = document.createElement('div');
                    daysHeader.className = 'calendar-days-header';
                    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    daysOfWeek.forEach(day => {
                        const dayElement = document.createElement('div');
                        dayElement.className = 'calendar-day-header';
                        dayElement.textContent = day;
                        daysHeader.appendChild(dayElement);
                    });
                    monthContainer.appendChild(daysHeader);
                    
                    const daysGrid = document.createElement('div');
                    daysGrid.className = 'calendar-days-grid';
                    
                    // Get the first day of the month
                    const firstDate = new Date(monthDates[0].date);
                    const firstDay = new Date(firstDate.getFullYear(), firstDate.getMonth(), 1).getDay();
                    
                    // Add empty cells for days before the first day of the month
                    for (let i = 0; i < firstDay; i++) {
                        const emptyCell = document.createElement('div');
                        emptyCell.className = 'calendar-day empty';
                        daysGrid.appendChild(emptyCell);
                    }
                    
                    // Add cells for each day of the month
                    monthDates.forEach(date => {
                        const dayCell = document.createElement('div');
                        dayCell.className = 'calendar-day';
                        dayCell.textContent = new Date(date.date).getDate();
                        
                        if (date.available) {
                            dayCell.classList.add('available');
                            dayCell.addEventListener('click', () => toggleDateSelection(date.date, dayCell));
                        } else {
                            dayCell.classList.add('unavailable');
                            if (date.bookings && date.bookings.length > 0) {
                                const tooltip = document.createElement('div');
                                tooltip.className = 'tooltip';
                                tooltip.textContent = `Booked by: ${date.bookings.map(b => b.pet_name).join(', ')}`;
                                dayCell.appendChild(tooltip);
                            }
                        }
                        
                        if (selectedDates.has(date.date)) {
                            dayCell.classList.add('selected');
                        }
                        
                        daysGrid.appendChild(dayCell);
                    });
                    
                    monthContainer.appendChild(daysGrid);
                    availabilityCalendar.appendChild(monthContainer);
                });
            }
            
            function toggleDateSelection(date, element) {
                if (selectedDates.has(date)) {
                    selectedDates.delete(date);
                    element.classList.remove('selected');
                } else {
                    selectedDates.add(date);
                    element.classList.add('selected');
                }
            }
            
            function showError(message) {
                alert(message);
            }
            
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
        });
    </script>
    <?php include ('components/footer_mini.php'); ?>
</body>
</html>