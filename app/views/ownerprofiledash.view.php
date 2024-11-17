
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?= ROOT ?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/ownerprofile.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/sidebar.css">
</head>
<body>
    <?php include 'components/nav.php'; ?>
    <div class="dashboard-container">
    <?php
        include 'components/renderSidebar.php'; 
        echo renderSidebar(ROOT, $petowner);
        ?>

        <!-- Main content area -->
        <div class="main-content">
            <h1>Your Pets</h1>
            <p>Click on a pet to view more details about them or add a new pet.</p>
            <div class="pets-container">
                <!-- Pet 1 -->
                <a href="<?= ROOT ?>/petprofile" class="pet-card">
                    <img src="<?= ROOT ?>/assets/images/happy-pets.jpg" alt="Dog 1" class="pet-image">
                    <h2>Dog 1</h2>
                </a>

                <!-- Pet 2 -->
                <a href="<?= ROOT ?>/petprofile" class="pet-card">
                    <img src="<?= ROOT ?>/assets/images/happy-pets.jpg" alt="Dog 2" class="pet-image">
                    <h2>Dog 2</h2>
                </a>

                <!-- Add New Pet -->
                <a href="<?= ROOT ?>/petprofile" class="pet-card">
                    <img src="<?= ROOT ?>/assets/images/pluse.jpg" alt="Add New Pet" class="pet-image">
                    <h2>Add New Pet</h2>
                </a>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="<?= ROOT ?>/assets/js/script.js"></script>
</body>
</html>
