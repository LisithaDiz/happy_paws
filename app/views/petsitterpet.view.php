<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vettreatedpets.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <title>Happy Paws - Pet Details</title>

    

</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar_pet_sitter.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <div class="overview-cards">
                <h1>Completed Appointments</h1>
                
                <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <div class="prescription-card" id="appointment-<?= $appointment->appointment_id ?>">
                            <div class="pet-info">
                                <img src="<?=ROOT?>/assets/images/background3.jpeg" alt="<?= htmlspecialchars($appointment->pet_name) ?>" class="pet-photo">
                                <div>
                                    <h3><?= htmlspecialchars($appointment->pet_name) ?></h3>
                                    <p>Age: <?= htmlspecialchars($appointment->age) ?> years</p>
                                    <p>Type: <?= htmlspecialchars($appointment->pet_type) ?></p>
                                    <p>Breed: <?= htmlspecialchars($appointment->breed) ?></p>
                                    <p>Appointment Date: <?= date('F j, Y', strtotime($appointment->day_of_appointment)) ?></p>
                                </div>
                            </div>
                            <div class="appointment-status">
                                <span class="status-badge completed">Completed</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No completed appointments found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

        

        

        <?php include ('components/footer_mini.php'); ?>
<!--    
        <script src="<?=ROOT?>/assets/js/script.js"></script> -->

       


    
   
</body>
</html>