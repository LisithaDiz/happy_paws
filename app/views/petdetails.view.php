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
        echo renderSidebar(ROOT, $petowner);
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-section">
            <div class="profile-content">
                <!-- Profile Picture -->
                <div class="profile-picture">
                    <img src="<?=ROOT?>/assets/images/background1.jpeg" alt="Profile Picture">
                </div>

                <div class="profile-details">
                    <h1>Pet Profile</h1>
                    <br/>

                    <?php
                    $pet_attributes = [
                        'Pet ID' => $pet['pet_id'] ?? 'N/A',
                        'Owner ID' => $pet['owner_id'] ?? 'N/A',
                        'Name' => $pet['pet_name'] ?? 'N/A',
                        'Type' => $pet['pet_type'] ?? 'N/A',
                        'Breed' => $pet['breed'] ?? 'N/A',
                        'Age' => $pet['age'] ?? 'N/A' . ' years',
                        'Color' => $pet['color'] ?? 'N/A',
                        'Weight' => $pet['weight'] ?? 'N/A' . ' kg',
                        'Vaccinations' => $pet['vaccinations'] ?? 'N/A',
                        'Date of Birth' => $pet['date_of_birth'] ?? 'N/A',
                    ];

                    foreach ($pet_attributes as $label => $value) {
                        echo "
                            <div class='detail-line'>
                                <div class='detail-label'>$label</div>
                                <div class='colon'>:</div>
                                <div class='detail-value'>$value</div>
                            </div>
                        ";
                    }
                    ?>
                <a href="<?= ROOT ?>/PetUpdate/index?pet_id=<?= $pet['pet_id'] ?>&owner_id=<?= $pet['owner_id'] ?>" class="update-btn">Update Pet Details</a>

                <form method="POST" action="<?= ROOT ?>/PetDetails/deletePet" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                    <input type="hidden" name="pet_id" value="<?php echo $pet['pet_id'] ?? ''; ?>">
                    <button type="submit" class="delete-btn">Delete Pet</button>
                </form>

                <a href="<?= ROOT ?>/petownerprescriptions" class="update-btn">View Prescription</a>

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