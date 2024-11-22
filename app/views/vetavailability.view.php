<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetavailability.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">

    

</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <div class="sidebar">
            <ul>
                <li><a href="<?=ROOT?>/vetdash">Dashboard</a></li>
                <li><a href="<?=ROOT?>/vetprofile">My Profile</a></li>
                <li><a href="<?=ROOT?>/vetappoinment">Upcoming Appointments</a></li>
                <li><a href="<?=ROOT?>/vetrequest">Appointment Requests</a></li>    
                <li><a href="<?=ROOT?>/vettreatedpet">View Pets</a></li>
                <li><a href="<?=ROOT?>/vetprescription">Prescriptions</a></li>
                <li><a href="<?=ROOT?>/vetavailability">Update Availability</a></li>
                <li><a href="<?=ROOT?>/vetmedrequest">Request to Add Medicine</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
        <h1>Update Availability</h1>
            <form action="" method="POST">
                <?php 
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                foreach ($days as $day): 
                ?>
                    <div class="form-group">
                        <label for="<?= strtolower($day) ?>"><?= $day ?>:</label><br>
                        <label>Start Time:</label>
                        <input type="time" name="availability[<?= $day ?>][start_time]">
                        <label>End Time:</label>
                        <input type="time" name="availability[<?= $day ?>][end_time]">
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn-primary">Update Availability</button>
            </form>

        </div>

    </div>
    
    <?php include ('components/footer.php'); ?>
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->
   
</body>
</html>