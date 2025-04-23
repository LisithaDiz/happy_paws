<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <!-- Add sidebar.css before other component styles -->
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for pharmacy functionalities -->
        <?php include ('components/sidebar2.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2>Welcome, <?php echo $pharmacy_name ?? 'Chathura'; ?>!</h2>
                <p class="subtitle">Manage your pharmacy operations efficiently</p>
            </div>

            <!-- Quick Stats Section -->
            <section class="stats-section">
                <h2><i class="fas fa-chart-line"></i> Quick Statistics</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-money-bill-wave"></i>
                        <div class="stat-info">
                            <h3>Total Revenue</h3>
                            <p class="stat-value">Rs. <?php echo number_format($total_revenue ?? 0); ?></p>
                            <a href="<?=ROOT?>/revenue" class="stat-link">View Details</a>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="stat-info">
                            <h3>Pending Orders</h3>
                            <p class="stat-value"><?php echo $pending_orders ?? 0; ?></p>
                            <a href="<?=ROOT?>/orders" class="stat-link">Manage Orders</a>
                        </div>
                    </div>
                   
                </div>
            </section>

            <!-- Quick Actions Section -->
            <section class="quick-actions">
                <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
                <div class="actions-grid">
                    <button class="action-btn" id="requestMedicineBtn">
                        <i class="fas fa-plus-circle"></i>
                        <span>Request Medicine</span>
                    </button>
                    <a href="<?=ROOT?>/orders" class="action-btn">
                        <i class="fas fa-file-medical"></i>
                        <span>New Order</span>
                    </a>
                    
                    <a href="<?=ROOT?>/report" class="action-btn">
                        <i class="fas fa-chart-bar"></i>
                        <span>Generate Report</span>
                    </a>
                </div>
            </section>

            <!-- Recent Activity Section -->
            <section class="recent-activity">
                <h2><i class="fas fa-history"></i> Recent Activity</h2>
                <div class="activity-list">
                    <?php
                    // Get notifications using the Notification model
                    $notification = new Notification();
                    $notifications = $notification->getNotifications($_SESSION['pharmacy_id'], 5);

                    if (empty($notifications)) {
                        echo '<p class="no-activity">No recent activity</p>';
                    } else {
                        foreach ($notifications as $notification) {
                            echo '<div class="activity-item">';
                            echo '<div class="activity-icon">';
                            if ($notification->type === 'new_order') {
                                echo '<i class="fas fa-shopping-cart"></i>';
                            } else {
                                echo '<i class="fas fa-bell"></i>';
                            }
                            echo '</div>';
                            echo '<div class="activity-content">';
                            echo '<p>' . htmlspecialchars($notification->message) . '</p>';
                            echo '<span class="activity-time">' . $notification->time_ago . '</span>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </section>

            <!-- Support Section -->
            <section class="support-section">
                <h2><i class="fas fa-headset"></i> Need Assistance?</h2>
                <div class="support-content">
                    <p>Our support team is here to help you 24/7</p>
                    <a href="<?=ROOT?>/pharmacy/contact" class="support-btn">Contact Support</a>
                </div>
            </section>
        </div>

    </div>
    
    
   
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
