<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?= ROOT ?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/sidebar.css">
</head>
<body>
    <?php 
    include 'components/nav.php';
    ?>

    <div class="dashboard-container">
        <?php
        include 'components/renderSidebar.php'; 
        echo renderSidebar(ROOT, $vet);
        ?>

        <!-- Main content area -->
        <div class="main-content">
            <h1>Welcome, Dr. <?= htmlspecialchars($vetName ?? 'Guest') ?>!</h1>
            <p>We're glad to have you back. Your dashboard provides you with all the tools you need to manage appointments, pet records, prescriptions, and more.</p>

            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Upcoming Appointments</h3>
                        <p>3 appointments scheduled for today.</p>
                        <a href="<?= ROOT ?>/vetappoinment" class="btn-dashboard">View upcoming appointments</a>
                    </div>
                    <div class="card">
                        <h3>Appointment Requests</h3>
                        <p>6 requests received.</p>
                        <a href="<?= ROOT ?>/vetrequest" class="btn-dashboard">View received requests</a>
                    </div>
                    <div class="card">
                        <h3>Prescriptions</h3>
                        <p>2 prescriptions to be filled today.</p>
                        <a href="<?= ROOT ?>/vet/prescriptions" class="btn-dashboard">View prescriptions</a>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="contact">
                <h2>Need Help?</h2>
                <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                <a href="<?= ROOT ?>/vet/contact" class="btn-dashboard">Contact Support</a>
            </section>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>

    <script src="<?= ROOT ?>/assets/js/script.js"></script>
</body>
</html>
