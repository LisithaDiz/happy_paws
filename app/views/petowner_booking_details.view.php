<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Details</title>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petowner_bookings.css">
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar_pet_owner.php'); ?>

        <div class="main-content">
            <div class="booking-details-container">
                <h1>Booking Details</h1>

                <?php if(isset($message)): ?>
                    <div class="alert alert-<?= $message_type ?>">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <div class="booking-details-card">
                    <div class="details-section">
                        <h2>Care Center Information</h2>
                        <p><strong>Care Center:</strong> <?= htmlspecialchars($booking->care_center_name) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($booking->address) ?></p>
                        <p><strong>Contact:</strong> <?= htmlspecialchars($booking->contact) ?></p>
                    </div>

                    <div class="details-section">
                        <h2>Pet Information</h2>
                        <p><strong>Pet Name:</strong> <?= htmlspecialchars($booking->pet_name) ?></p>
                        <p><strong>Pet Type:</strong> <?= htmlspecialchars($booking->pet_type) ?></p>
                        <p><strong>Breed:</strong> <?= htmlspecialchars($booking->breed) ?></p>
                    </div>

                    <div class="details-section">
                        <h2>Booking Information</h2>
                        <p><strong>Booking ID:</strong> <?= htmlspecialchars($booking->booking_id) ?></p>
                        <p><strong>Check-in Date:</strong> <?= htmlspecialchars($booking->start_date) ?></p>
                        <p><strong>Check-out Date:</strong> <?= htmlspecialchars($booking->end_date) ?></p>
                        <p><strong>Cage:</strong> <?= htmlspecialchars($booking->cage_name) ?></p>
                        <p><strong>Status:</strong> <span class="status-badge <?= strtolower($booking->status) ?>"><?= htmlspecialchars($booking->status) ?></span></p>
                        <?php if($booking->special_req): ?>
                            <p><strong>Special Requirements:</strong> <?= htmlspecialchars($booking->special_req) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="booking-actions">
                        <a href="<?= ROOT ?>/CareCenterProfile/view/<?= $booking->care_center_id ?>" class="view-center-btn">View Care Center</a>
                        <a href="<?= ROOT ?>/petownerBookings" class="back-btn">Back to Bookings</a>
                        <?php if($booking->status !== 'Cancelled' && $booking->start_date >= date('Y-m-d')): ?>
                            <button class="cancel-btn" 
                                onclick="setCancelUrl('<?= ROOT ?>/PetOwnerBookings/cancelBooking/<?= $booking->booking_id ?>'); openCancelPopup();">
                                Cancel Booking
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('components/footer_mini.php'); ?>

    <!-- Cancel Confirmation Popup -->
    <div id="cancelPopup" class="popup-overlay">
        <div class="popup-box">
            <p>Are you sure you want to cancel this booking?</p>
            <p><strong>Note:</strong> Refund should be collected by visiting the Care Center.</p>
            <div class="popup-actions">
                <button onclick="confirmCancel()" class="popup-btn confirm">Yes, Cancel</button>
                <button onclick="closeCancelPopup()" class="popup-btn">No</button>
            </div>
        </div>
    </div>

    <script>
        let cancelUrl = '';
        
        function setCancelUrl(url) {
            cancelUrl = url;
        }
        
        function openCancelPopup() {
            document.getElementById('cancelPopup').style.display = 'flex';
        }
        
        function closeCancelPopup() {
            document.getElementById('cancelPopup').style.display = 'none';
        }
        
        function confirmCancel() {
            window.location.href = cancelUrl;
        }
    </script>
</body>
</html> 