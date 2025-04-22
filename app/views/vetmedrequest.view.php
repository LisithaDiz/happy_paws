<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetmedrequest.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Vet Medicine Request</title>

    

</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar3.php'); ?>

    

        <!-- Main content area -->
        <div class="main-content">
            <h1>Request to add medicine</h1>
            <form action="<?=ROOT?>/VetMedRequest/addMedicineRequest" method="POST">
                <label for="medicine_name">Medicine Name:</label><br>
                <input type="text" id="medicine_name" name="medicine_name" required><br><br>
                
                <label for="note">Note (Optional):</label><br>
                <textarea id="note" name="note"></textarea><br><br>
                
                <button type="submit">Submit Request</button>
            </form>

        </div>
    
    </div>

    
    <?php include ('components/footer.php'); ?>

   
</body>
</html>