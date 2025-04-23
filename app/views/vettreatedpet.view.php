<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vettreatedpets.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Treated Pets</title>


</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar3.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <div class="overview-cards">
                    <h1>Treated Pets</h1>
                    
                    <?php if(isset($petDetails) && !empty($petDetails)):?>
                        <?php foreach ($petDetails as $petDetail):?>
                            <div class="prescription-card" id="prescription1">
                                <div class="pet-info">
                                    <img src="<?=ROOT?>/assets/images/background3.jpeg" alt="Buddy" class="pet-photo">
                                    <div>
                                        <h2>Pet Name: <?= htmlspecialchars($petDetail->pet_name) ?></h2>
                                        <p>Owner Name: <?= htmlspecialchars($petDetail->f_name) ?> <?= htmlspecialchars($petDetail->l_name) ?></p>
                                        <p>Age: <?= htmlspecialchars($petDetail->age) ?></p>
                                    </div>
                                </div>
                                <button class="btn-dashboard" >View Pet</button>
                            </div>
                        <?php endforeach;?>
                    <?php else:?>
                        <h1>No pets treated yet.</h1>
                    <?php endif;?>

                    </div>
                </div>
            </div>
        </div>

        
        <?php include ('components/footer.php'); ?>
<!--    
        <script src="<?=ROOT?>/assets/js/script.js"></script> -->

    
</body>
</html>