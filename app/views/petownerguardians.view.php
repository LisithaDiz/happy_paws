<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?= ROOT ?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/petownerdash.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/sidebar.css">
</head>
<body>
    <?php include 'components/nav2.php'; ?>

    <div class="dashboard-container">
    <?php include ('components/sidebar.php'); ?>

        <div class="main-content">
            <h1>Select our gardian !</h1>

            <section class="dashboard-overview">
                <div class="overview-cards">

                    <div class="card">
                        <img src="<?= ROOT ?>/assets/images/petsitter_.jpg" alt="Default Pet Image" class="pet-profile-pic">
                        <h3>Find pet sitter</h3>
                        <a href="<?= htmlspecialchars(ROOT) ?>/PetsitterSearch" class="btn-dashboard">Select</a>
                    </div>
                    <div class="card">
                        <img src="<?= ROOT ?>/assets/images/petcare_.jpg" alt="Default Pet Image" class="pet-profile-pic">
                        <h3>Find pet care center</h3>
                        <a href="<?= htmlspecialchars(ROOT) ?>/Petcaresearch" class="btn-dashboard">Select</a>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="<?= ROOT ?>/assets/js/script.js"></script>
</body>
</html>
