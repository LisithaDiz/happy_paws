<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetview_petprofile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petownerappointments.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Pet Profile</title>
</head>
<body>

<?php include('components/nav2.php'); ?>

<div class="dashboard-container">
    <?php include('components/sidebar3.php'); ?>

    <div class="main-content">

        <div class="pet-profile-container">
            <?php if(!empty($petDetails)): 
                $pet = $petDetails[0];
            ?>
                <div class="pet-profile-card">
                    <div class="pet-image">
                        <img src="<?=ROOT?>/assets/images/pets/default-pet.jpg" alt="<?=htmlspecialchars($pet->pet_name)?>">
                    </div>
                    <div class="pet-details">
                        <h2><?=htmlspecialchars($pet->pet_name)?></h2>
                        <ul>
                            <li><strong>Type:</strong> <?=htmlspecialchars($pet->pet_type)?></li>
                            <li><strong>Breed:</strong> <?=htmlspecialchars($pet->breed)?></li>
                            <li><strong>Age:</strong> <?=htmlspecialchars($pet->age)?> Years</li>
                            <li><strong>Gender:</strong> <?=htmlspecialchars($pet->gender)?></li>
                            <li><strong>Color:</strong> <?=htmlspecialchars($pet->color)?></li>
                            <li><strong>Weight:</strong> <?=htmlspecialchars($pet->weight)?> kg</li>
                            <li><strong>Vaccinations:</strong> <?=htmlspecialchars($pet->vaccinations)?></li>
                            <li><strong>Date of Birth:</strong> <?=htmlspecialchars($pet->date_of_birth)?></li>
                        </ul>
                    </div>
                </div>

                <div class="vet-actions">
                    <form method="POST" action="<?=ROOT?>/vetprescription/add">
                        <input type="hidden" name="pet_id" value="<?=htmlspecialchars($pet->pet_id)?>">
                        <button type="submit" class="btn">Issue Prescription</button>
                    </form>

                    <form method="POST" action="<?=ROOT?>/vetmedicalrecord/update">
                        <input type="hidden" name="pet_id" value="<?=htmlspecialchars($pet->pet_id)?>">
                        <button type="submit" class="btn secondary">Update Medical Record</button>
                    </form>
                </div>

            <?php else: ?>
                <p>No pet data found.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include('components/footer.php'); ?>
<script src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>
