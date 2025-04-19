<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <title>Cage Management</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecentercage.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
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

                <!-- View Toggle -->
                <div class="view-toggle">
                    <button class="view-btn active" data-view="tiles"><i class="fas fa-th-large"></i> Tiles</button>
                    <button class="view-btn" data-view="table"><i class="fas fa-table"></i> Table</button>
                </div>

                <!-- Cage Tiles View -->
                <div class="cage-tiles-view">
                    <div class="cage-grid">
                        <?php if (!empty($cages)) : ?>
                            <?php foreach ($cages as $cage): ?>
                                <div class="cage-tile">
                                    <div class="cage-image">
                                        <img src="<?=ROOT?>/assets/images/cages/<?= htmlspecialchars($cage->image_name ?? 'default-cage.jpg') ?>" 
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
                                        
                                        <div class="cage-availability">
                                            <div class="availability-meter">
                                                <div class="meter-bar" style="width: <?= ($cage->available_cages / $cage->number_of_cages) * 100 ?>%"></div>
                                                <span><?= htmlspecialchars($cage->available_cages) ?>/<?= htmlspecialchars($cage->number_of_cages) ?> available</span>
                                            </div>
                                        </div>
                                        
                                        <div class="cage-actions">
                                            <button class="btn-edit" 
                                                data-id="<?= $cage->id ?>"
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
                                            
                                            <form method="POST" action="<?=ROOT?>/careCenter/deleteCage" onsubmit="return confirmDelete()">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($cage->id) ?>">
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
                    <!-- Add cage form same as before -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <!-- Same as before -->

    <script>
        // View Toggle Functionality
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Update active state
                document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Show/hide views
                const view = this.getAttribute('data-view');
                if (view === 'tiles') {
                    document.querySelector('.cage-tiles-view').style.display = 'block';
                    document.querySelector('.cage-table-view').style.display = 'none';
                } else {
                    document.querySelector('.cage-tiles-view').style.display = 'none';
                    document.querySelector('.cage-table-view').style.display = 'block';
                }
            });
        });

        // Rest of your JavaScript remains the same
    </script>
</body>
</html>