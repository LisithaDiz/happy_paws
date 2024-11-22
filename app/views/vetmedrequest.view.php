<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetmedrequest.css">
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
            <h1>Request to add medicine</h1>
            <form action="/happy_paws/public/vet/medicine_request" method="POST">
                <label for="medicine_name">Medicine Name:</label><br>
                <input type="text" id="medicine_name" name="medicine_name" required><br><br>
                
                <label for="note">Note (Optional):</label><br>
                <textarea id="note" name="note"></textarea><br><br>
                
                <button type="submit">Submit Request</button>
            </form>

        </div>
    
    </div>

    
    <?php include ('components/footer.php'); ?>
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->
   
</body>
</html>