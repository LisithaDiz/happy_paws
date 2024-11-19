<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petadd.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Edit Pet Profile</title>
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
    <form method="POST" action="<?= ROOT ?>/PetUpdate/updatePetDetails?pet_id=<?= $pet['pet_id'] ?>&owner_id=<?= $pet['owner_id'] ?>" class="form-container">
    <h2 class="form-title">Update Pet Details</h2>

    <div class="form-group">
        <label for="owner_id">Owner ID:</label>
        <input type="text" id="owner_id" name="owner_id" value="<?= $pet['owner_id'] ?>" required>
    </div>

    <div class="form-group">
        <label for="pet_name">Pet Name:</label>
        <input type="text" id="pet_name" name="pet_name" value="<?= $pet['pet_name'] ?>" required>
    </div>

    <div class="form-group">
        <label for="pet_type">Pet Type:</label>
        <input type="text" id="pet_type" name="pet_type" value="<?= $pet['pet_type'] ?>" required>
    </div>

    <div class="form-group">
        <label for="breed">Breed:</label>
        <input type="text" id="breed" name="breed" value="<?= $pet['breed'] ?>">
    </div>

    <div class="form-group">
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" min="0" value="<?= $pet['age'] ?>">
    </div>

    <div class="form-group">
        <label for="color">Color:</label>
        <input type="text" id="color" name="color" value="<?= $pet['color'] ?>">
    </div>

    <div class="form-group">
        <label for="weight">Weight (kg):</label>
        <input type="number" id="weight" name="weight" step="0.1" min="0" value="<?= $pet['weight'] ?>">
    </div>

    <div class="form-group">
        <label for="vaccinations">Vaccinations:</label>
        <input type="text" id="vaccinations" name="vaccinations" value="<?= $pet['vaccinations'] ?>">
    </div>

    <div class="form-group">
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?= $pet['date_of_birth'] ?>">
    </div>

    <button type="submit" class="form-btn">Update Pet</button>
</form>

    </div>
</div>

    <!-- Footer -->
    <?php include('components/footer.php'); ?>

    <script src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>
