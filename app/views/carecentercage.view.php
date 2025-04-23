<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecentercage.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <title>Happy Paws - My Cages</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <?php include ('components/sidebar_care_center.php'); ?>

        <div class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-archway"></i> Cage Management</h1>
                <p>Manage your pet care center's cages and availability</p>
            </div>

            <div class="card-container">
                <!-- Search Section -->
                <div class="card search-card">
                    <div class="card-header">
                        <h2><i class="fas fa-search"></i> Search Cages</h2>
                    </div>
                    <div class="card-body">
                        <div class="search-container">
                            <input type="text" id="search" name="search" placeholder="Search by cage name, location, or features...">
                            <button class="search-btn"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>

                <div class="cage-tiles-view">
                    <div class="cage-grid">
                        <?php if (!empty($cages)) : ?>
                            <?php foreach ($cages as $cage): ?>
                                <div class="cage-tile">
                                    <div class="cage-image">
                                        <img src="data:image/jpeg;base64,<?= base64_encode($cage->cage_img) ?>" 
                                             alt="<?= htmlspecialchars($cage->cage_name) ?>">
                                        <span class="availability-badge <?= $cage->available_cages > 0 ? 'available' : 'unavailable' ?>">
                                            <?= $cage->available_cages > 0 ? 'Available' : 'Booked Out' ?>
                                        </span>
                                    </div>
                                    
                                    <div class="cage-info">
                                        <h3><?= htmlspecialchars($cage->cage_name) ?></h3>
                                        
                                        <div class="cage-specs">
                                            <div class="spec-item">
                                                <i class="fas fa-paw"></i>
                                                <span><?= htmlspecialchars($cage->designed_for) ?></span>
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-ruler-combined"></i>
                                                <span><?= htmlspecialchars($cage->height) ?>x<?= htmlspecialchars($cage->length) ?>x<?= htmlspecialchars($cage->width) ?> cm</span>
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span><?= htmlspecialchars($cage->location) ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="cage-features">
                                            <p><?= htmlspecialchars($cage->additional_features) ?></p>
                                        </div>
                                        
                                        <!-- <div class="cage-availability">
                                            <div class="availability-meter">
                                                <div class="meter-bar" style="width: <?= ($cage->available_cages / $cage->number_of_cages) * 100 ?>%"></div>
                                                <span><?= htmlspecialchars($cage->available_cages) ?>/<?= htmlspecialchars($cage->number_of_cages) ?> available</span>
                                            </div>
                                        </div> -->
                                        
                                        <div class="cage-actions">
                                            <button class="btn-edit" 
                                                data-cage-id="<?= $cage->cage_id ?>"
                                                data-cage-name="<?= htmlspecialchars($cage->cage_name) ?>"
                                                data-number-of-cages="<?= htmlspecialchars($cage->number_of_cages) ?>"
                                                data-height="<?= htmlspecialchars($cage->height) ?>"
                                                data-length="<?= htmlspecialchars($cage->length) ?>"
                                                data-width="<?= htmlspecialchars($cage->width) ?>"
                                                data-designed-for="<?= htmlspecialchars($cage->designed_for) ?>"
                                                data-location="<?= htmlspecialchars($cage->location) ?>"
                                                data-additional-features="<?= htmlspecialchars($cage->additional_features) ?>"
                                                data-available-cages="<?= htmlspecialchars($cage->available_cages) ?>"
                                                onclick="openEditModal(this)">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            
                                            <form method="POST" action="<?=ROOT?>/careCenterCage/deleteCage" onsubmit="return confirmDelete()">
                                                <input type="hidden" name="cage_id" value="<?= htmlspecialchars($cage->cage_id) ?>">
                                                <button type="submit" class="btn-delete">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="no-cages">
                                <i class="fas fa-box-open"></i>
                                <p>No cages found in your inventory</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Cage Table View (Hidden by default) -->
                <div class="cage-table-view" style="display: none;">
                    <div class="table-responsive">
                        <table class="cage-table">
                            <!-- Table content same as before -->
                        </table>
                    </div>
                </div>

                <!-- Add Cage Section -->
                <div class="card add-cage-card">
                    <div class="card-header">
                        <h2><i class="fas fa-plus"></i> Add New Cage</h2>
                    </div>
                    <div class="card-body">
                        <form class="cage-form" action="<?=ROOT?>/careCenter/addCage" method="POST" onsubmit="return validateCageForm()">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="cage_name">
                                        <i class="fas fa-signature"></i>
                                        Cage Name
                                    </label>
                                    <input type="text" id="cage_name" name="cage_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="number_of_cages">
                                        <i class="fas fa-boxes"></i>
                                        Number of Cages
                                    </label>
                                    <input type="number" id="number_of_cages" name="number_of_cages" min="0" step="1" required>
                                </div>

                                <div class="form-group">
                                    <label for="designed_for">
                                        <i class="fas fa-paw"></i>
                                        Designed for
                                    </label>
                                    <select id="designed_for" name="designed_for" required>
                                        <option value="">Select</option>
                                        <option value="dogs">Dogs</option>
                                        <option value="cats">Cats</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Location
                                    </label>
                                    <select id="location" name="location" required>
                                        <option value="">Select</option>
                                        <option value="indoor">Indoor</option>
                                        <option value="outdoor(shelter)">Outdoor (In a Shelter)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="additional_features">
                                        <i class="fas fa-list"></i>
                                        Additional Features
                                    </label>
                                    <input type="text" id="additional_features" name="additional_features" required>
                                </div>

    

                                <div class="form-group dimension-inputs">
                                    <label>
                                        <i class="fas fa-ruler-combined"></i>
                                        Dimensions (cm)
                                    </label>
                                    <div class="dimension-grid">
                                        <input type="number" id="height" name="height" placeholder="Height" min="0" step="0.1" required>
                                        <input type="number" id="length" name="length" placeholder="Length" min="0" step="0.1" required>
                                        <input type="number" id="width" name="width" placeholder="Width" min="0" step="0.1" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-submit" name="add_cage">
                                <i class="fas fa-plus"></i>
                                Add Cage
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-edit"></i> Edit Cage</h2>
                <button class="close-modal" onclick="closeEditModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="cage-form" method="POST" action="<?=ROOT?>/careCenterCage/updateCage" onsubmit="return validateEditForm()">
                    <input type="hidden" id="edit_cage_id" name="cage_id">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="edit_cage_name">
                                <i class="fas fa-signature"></i>
                                Cage Name
                            </label>
                            <input type="text" id="edit_cage_name" name="cage_name" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_number_of_cages">
                                <i class="fas fa-boxes"></i>
                                Number of Cages
                            </label>
                            <input type="number" id="edit_number_of_cages" name="num_of_cages" min="0" step="1" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_designed_for">
                                <i class="fas fa-paw"></i>
                                Designed for
                            </label>
                            <select id="edit_designed_for" name="designed_for" required>
                                <option value="">Select</option>
                                <option value="dogs">Dogs</option>
                                <option value="cats">Cats</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_location">
                                <i class="fas fa-map-marker-alt"></i>
                                Location
                            </label>
                            <select id="edit_location" name="location" required>
                                <option value="">Select</option>
                                <option value="indoor">Indoor</option>
                                <option value="outdoor(shelter)">Outdoor (In a Shelter)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_additional_features">
                                <i class="fas fa-list"></i>
                                Additional Features
                            </label>
                            <input type="text" id="edit_additional_features" name="additional_features" required>
                        </div>

                        <div class="form-group dimension-inputs">
                            <label>
                                <i class="fas fa-ruler-combined"></i>
                                Dimensions (cm)
                            </label>
                            <div class="dimension-grid">
                                <input type="number" id="edit_height" name="height" placeholder="Height" min="0" step="0.1" required>
                                <input type="number" id="edit_length" name="length" placeholder="Length" min="0" step="0.1" required>
                                <input type="number" id="edit_width" name="width" placeholder="Width" min="0" step="0.1" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i>
                            Update Cage
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Form validation function
        function validateCageForm() {
            const cageName = document.getElementById('cage_name').value.trim();
            const numberOfCages = document.getElementById('number_of_cages').value;
            const designedFor = document.getElementById('designed_for').value;
            const location = document.getElementById('location').value;
            const additionalFeatures = document.getElementById('additional_features').value.trim();
            const availableCages = document.getElementById('available_cages').value;
            const height = document.getElementById('height').value;
            const length = document.getElementById('length').value;
            const width = document.getElementById('width').value;
            
            // Check if all required fields are filled
            if (!cageName || !numberOfCages || !designedFor || !location || !additionalFeatures || 
                !availableCages || !height || !length || !width) {
                alert('Please fill in all required fields');
                return false;
            }
            
            // Validate numeric values
            if (isNaN(numberOfCages) || numberOfCages <= 0) {
                alert('Number of cages must be a positive number');
                return false;
            }
            
            if (isNaN(availableCages) || availableCages < 0) {
                alert('Available cages must be a non-negative number');
                return false;
            }
            
            if (parseInt(availableCages) > parseInt(numberOfCages)) {
                alert('Available cages cannot be greater than the total number of cages');
                return false;
            }
            
            if (isNaN(height) || height <= 0 || isNaN(length) || length <= 0 || isNaN(width) || width <= 0) {
                alert('Dimensions must be positive numbers');
                return false;
            }
            
            return true;
        }
        
        // Form validation function for edit form
        function validateEditForm() {
            const cageName = document.getElementById('edit_cage_name').value.trim();
            const numberOfCages = document.getElementById('edit_number_of_cages').value;
            const designedFor = document.getElementById('edit_designed_for').value;
            const location = document.getElementById('edit_location').value;
            const additionalFeatures = document.getElementById('edit_additional_features').value.trim();
            const height = document.getElementById('edit_height').value;
            const length = document.getElementById('edit_length').value;
            const width = document.getElementById('edit_width').value;
            
            // Check if all required fields are filled
            if (!cageName || !numberOfCages || !designedFor || !location || !additionalFeatures || 
                !height || !length || !width) {
                alert('Please fill in all required fields');
                return false;
            }
            
            // Validate numeric values
            if (isNaN(numberOfCages) || numberOfCages <= 0) {
                alert('Number of cages must be a positive number');
                return false;
            }
            
            if (isNaN(height) || height <= 0 || isNaN(length) || length <= 0 || isNaN(width) || width <= 0) {
                alert('Dimensions must be positive numbers');
                return false;
            }
            
            return true;
        }
        
        // Function to confirm cage deletion
        function confirmDelete() {
            return confirm('Are you sure you want to delete this cage? This action cannot be undone.');
        }
        
        // Function to open edit modal
        function openEditModal(button) {
            const modal = document.getElementById('editModal');
            const id = button.getAttribute('data-cage-id');
            const cageName = button.getAttribute('data-cage-name');
            const numberOfCages = button.getAttribute('data-number-of-cages');
            const height = button.getAttribute('data-height');
            const length = button.getAttribute('data-length');
            const width = button.getAttribute('data-width');
            const designedFor = button.getAttribute('data-designed-for');
            const location = button.getAttribute('data-location');
            const additionalFeatures = button.getAttribute('data-additional-features');
            
            // Set form values
            document.getElementById('edit_cage_id').value = id;
            document.getElementById('edit_cage_name').value = cageName;
            document.getElementById('edit_number_of_cages').value = numberOfCages;
            document.getElementById('edit_height').value = height;
            document.getElementById('edit_length').value = length;
            document.getElementById('edit_width').value = width;
            document.getElementById('edit_designed_for').value = designedFor;
            document.getElementById('edit_location').value = location;
            document.getElementById('edit_additional_features').value = additionalFeatures;
            
            // Show modal
            modal.style.display = 'flex';
        }
        
        // Function to close edit modal
        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
    <?php include ('components/footer_mini.php'); ?>
</body>
</html>