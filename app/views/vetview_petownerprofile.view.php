<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetview_petownerprofile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petownerappointments.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Pet Owner Profile</title>
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar3.php'); ?>

        <div class="main-content">

            <!-- Owner Profile Section -->
            <div class="owner-profile">
                <div class="owner-details">
                    <img src="<?=ROOT?>/assets/images/profilepic1.jpeg" alt="Profile Picture">
                    <div class="owner-info">
                        <?php if(!empty($petownerDetails)): ?>
                            <h2><?= htmlspecialchars($petownerDetails[0]->f_name . ' ' . $petownerDetails[0]->l_name) ?></h2>
                            <p>Email: <?= htmlspecialchars($petownerDetails[0]->email) ?></p> <!-- Assuming user_id is linked to the email -->

                            <!-- Message Button -->
                            <form method="POST" action="<?=ROOT?>/vetmessage/index">
                                <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($petownerDetails[0]->user_id) ?>">
                                <input type="hidden" name="receiver_role" value="1"> <!-- Assuming role 1 is Pet Owner -->
                                <button type="submit" class="message-btn">Message</button>
                            </form>
                        <?php else: ?>
                            <h2>Unknown Owner</h2>
                            <p>Email: N/A</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
       
            <!-- Pets Section -->
            <div class="pets-section">
                <h2>My Pets</h2>
                <div class="pet-cards">
                    <?php if(!empty($petDetails)): ?>
                        <?php foreach($petDetails as $pet): ?>
                            <form method="POST" action="<?=ROOT?>/vetview_petprofile/index" class="pet-form">
                                <input type="hidden" name="pet_id" value="<?=htmlspecialchars($pet->pet_id) ?>">
                                <button type="submit" class="pet-card">
                                    <img src="<?= ROOT ?>/assets/images/dog1.avif"  alt="<?=htmlspecialchars($pet->pet_name)?>">
                                    <div class="pet-card-content">
                                        <h3><?= htmlspecialchars($pet->pet_name) ?></h3>
                                        <p><?= htmlspecialchars($pet->pet_type) ?></p>
                                        <p>Breed: <?= htmlspecialchars($pet->breed) ?></p>
                                        <p>Age: <?= htmlspecialchars($pet->age) ?> Years</p>
                                    </div>
                                </button>
                            </form>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No pets found for this owner.</p>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </div>

    <?php include('components/footer.php'); ?>
    <script src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>

