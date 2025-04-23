<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?= ROOT ?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/petownerguardians.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/footer_mini.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Happy Paws - Find Pet Guardians</title>
</head>
<body>
    <?php include 'components/nav2.php'; ?>

    <div class="dashboard-container">
        <?php include ('components/sidebar_pet_owner.php'); ?>

        <div class="main-content">
            <h1 class="page-title">Find Your Pet's Perfect Guardian</h1>

            <div class="services-container">
                <!-- Pet Sitters Section -->
                <div class="service-section">
                    <div class="service-header">
                        <img src="<?= ROOT ?>/assets/images/petsitter_.jpg" alt="Pet Sitter" class="service-image">
                        <h2>Pet Sitters</h2>
                    </div>
                    <div class="service-options">
                        <div class="option-group">
                            <h3 class="option-group-title">Bookings</h3>
                            <a href="<?= htmlspecialchars(ROOT) ?>/PetsitterBookings" class="option-link">
                                <i class="fas fa-calendar-check"></i>
                                <span>View My Bookings</span>
                            </a>
                            <a href="<?= htmlspecialchars(ROOT) ?>/PetsitterBookings/create" class="option-link">
                                <i class="fas fa-search"></i>
                                <span>Search Pet Sitter</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pet Care Centers Section -->
                <div class="service-section">
                    <div class="service-header">
                        <img src="<?= ROOT ?>/assets/images/petcare_.jpg" alt="Pet Care Center" class="service-image">
                        <h2>Pet Care Centers</h2>
                    </div>
                    <div class="service-options">
                        <div class="option-group">
                            <h3 class="option-group-title">Bookings</h3>
                            <a href="<?= htmlspecialchars(ROOT) ?>/PetOwnerBookings" class="option-link">
                                <i class="fas fa-calendar-check"></i>
                                <span>View My Bookings</span>
                            </a>
                            <a href="<?= htmlspecialchars(ROOT) ?>/PetcareSearch" class="option-link">
                                <i class="fas fa-search"></i>
                                <span>Search Care Center</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/footer_mini.php'; ?>

    <script src="<?= ROOT ?>/assets/js/script.js"></script>
</body>
</html>
