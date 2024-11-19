<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?= ROOT ?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/petownerdash.css">
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
            <h1>Welcome, <?= htmlspecialchars($vetName ?? 'Guest') ?>!</h1>

            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Your Lovely Pets</h2>
                <div class="overview-cards">
                    <?php
                    include 'components/petCard.php';

                    renderPetCard("Pet 1", ROOT . "/assets/images/background1.jpeg", ROOT . "/petdetails");
                    renderPetCard("Pet 2", ROOT . "/assets/images/background2.jpeg", ROOT . "/petdetails");
                    renderPetCard("Pet 3", ROOT . "/assets/images/background3.jpeg", ROOT . "/petdetails");
                    renderPetCard("Pet 4", ROOT . "/assets/images/background4.jpeg", ROOT . "/petdetails");

                    renderPetCard("Add New Pet", ROOT . "/assets/images/plus.jpg", ROOT . "/add-pet");
                    ?>
                </div>
            </section>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="<?= ROOT ?>/assets/js/script.js"></script>
</body>
</html>
