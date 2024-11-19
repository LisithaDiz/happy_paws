<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petdetails.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Pet Profile</title>
</head>
<body>
    <!-- Navigation -->
    <?php include('components/nav.php'); ?>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php
        include 'components/renderSidebar.php';
        echo renderSidebar(ROOT, $vet);
        ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="profile-section">
                <!-- Profile Picture -->
                <div class="profile-picture">
                    <img src="<?=ROOT?>/assets/images/background1.jpeg" alt="Profile Picture">
                </div>

                <!-- Profile Details -->
                <div class="profile-details">
                    <h1>Pet Profile</h1>
                    <br/>

                    <!-- Replace these placeholder details with dynamic PHP content -->
                    <div class="detail-line">
                        <div class="detail-label">Name</div>
                        <div class="colon">:</div>
                        <div class="detail-value"><?= $pet['name'] ?? 'N/A' ?></div>
                    </div>
                    
                    <div class="detail-line">
                        <div class="detail-label">Breed</div>
                        <div class="colon">:</div>
                        <div class="detail-value"><?= $pet['breed'] ?? 'N/A' ?></div>
                    </div>

                    <div class="detail-line">
                        <div class="detail-label">Age</div>
                        <div class="colon">:</div>
                        <div class="detail-value"><?= $pet['age'] ?? 'N/A' ?> years</div>
                    </div>

                    <div class="detail-line">
                        <div class="detail-label">Owner</div>
                        <div class="colon">:</div>
                        <div class="detail-value"><?= $pet['owner'] ?? 'N/A' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('components/footer.php'); ?>

    <script src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>
