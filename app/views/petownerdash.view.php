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
                    include 'components/petcard.php';

                    // Check if there are pets and render them
                    if (!empty($data['pets'])) {
                        foreach ($data['pets'] as $pet) {
                            renderPetCard(
                                htmlspecialchars($pet['pet_name']),
                                htmlspecialchars(ROOT) . "/assets/images/background1.jpeg",
                                htmlspecialchars(ROOT) . "/petdetails?owner_id=1" . "&pet_id=" . htmlspecialchars($pet['pet_id'])
                            );
                        }
                    } else {
                        echo "<p>No pets found.</p>";
                    }

                    ?>
                    <div class="card">
                        <img src="<?= ROOT ?>/assets/images/plus.jpg" alt="Default Pet Image" class="pet-profile-pic">
                        <h3>New Pet</h3>
                        <a href="<?= htmlspecialchars(ROOT) ?>/petadd" class="btn-dashboard">Add New Pet</a>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="<?= ROOT ?>/assets/js/script.js"></script>
</body>
</html>
