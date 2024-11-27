<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">


</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <div class="sidebar">
            <h3>Pharmacy Dashboard</h3>
            <ul>
                <li><a href="<?=ROOT?>/PharmProfile">My Profile</a></li>
                <li><a href="<?=ROOT?>/Revenue">Revenue</a></li>
                <li><a href="<?=ROOT?>/Orders">Orders</a></li>    
                <!-- <li><a href="<?=ROOT?>/pharmacy/transactions">Transcation History</a></li> -->
                <!-- <li><a href="<?=ROOT?>/pharmacy/settings">Settings</a></li> -->
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <h1>Welcome, Mr. [Pharmacy Name]!</h1>
            <p>We're glad to have you back. Your dashboard provides you with all the tools you need to manage orders, Inventory records, and more.</p>

            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Total Revenue</h3>
                        <p></p>
                        <a href="<?=ROOT?>/revenue" class="btn-dashboard">View Revenue</a>
                    </div>
                    <div class="card">
                        <h3>Orders</h3>
                        <p>6 Orders received.</p>
                        <a href="<?=ROOT?>/orders" class="btn-dashboard">View orders</a>
                    </div>
                    <div class="card">
                        <h3>Request Medicine</h3>
                        <p>Request new medicines for your inventory</p>
                        <button class="btn-dashboard" id="requestMedicineBtn">Request Medicine</button>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="contact">
                <h2>Need Help?</h2>
                <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                <a href="<?=ROOT?>/pharmacy/contact" class="btn-dashboard">Contact Support</a>
            </section>
        </div>

    </div>
    
    <?php include ('components/footer.php'); ?>
   
    <!-- Modal -->
    <div id="requestMedicineModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Request Medicine</h2>
            <form action="<?=ROOT?>/pharmacy/requestMedicine" method="POST">
                <div class="form-group">
                    <label for="pharmacy-id">Pharmacy ID:</label>
                    <input type="text" id="pharmacy-id" name="pharmacy_id" required>
                </div>
                
                <div class="form-group">
                    <label for="medicine-name">Medicine Name:</label>
                    <input type="text" id="medicine-name" name="medicine_name" required>
                </div>
                
                <button type="submit" class="submit-btn">Submit Request</button>
            </form>
        </div>
    </div>

    <!-- Include both JavaScript files -->
    <script src="<?=ROOT?>/assets/js/script.js"></script>
    <script src="<?=ROOT?>/assets/js/modal.js"></script>
</body>
</html>
