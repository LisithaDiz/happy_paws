<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petowner_appointments.css">
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar.php'); ?>

        <div class="main-content">
            <h1><i class="fa-solid fa-calendar-check"></i> My Appointments</h1>

            <h2><i class="fa-solid fa-calendar-day"></i> Upcoming Appointments</h2><br/>
            <div class="appointments-list">
                <?php if(!empty($appointmentDetails)): ?>
                    <?php foreach($appointmentDetails as $appointment): ?>
                        <div class="appointment-card">
                            <div class="appointment-details">
                                <p><i class="fa-solid fa-user-doctor"></i> <strong>Vet Name:</strong> <?= htmlspecialchars($appointment->f_name) . ' ' . htmlspecialchars($appointment->l_name) ?></p>
                                <p><i class="fa-solid fa-calendar"></i> <strong>Date:</strong> <?= htmlspecialchars($appointment->appointment_date) ?></p>
                                <p><i class="fa-solid fa-clock"></i> <strong>Time:</strong> <?= htmlspecialchars($appointment->appointment_time) ?></p>
                                <p><i class="fa-solid fa-hourglass-start"></i> <strong>Status:</strong> <span class="status-badge">Pending</span></p>
                            </div>
                            <a href="<?= ROOT ?>/VetProfile/view/<?= $appointment->vet_id ?>" class="view-vet-btn"><i class="fa-solid fa-eye"></i> View Vet</a>
                            <button class="cancel-btn"
                                onclick="setCancelUrl('<?= ROOT ?>/PetOwner_Appointments/cancelAppointment/<?= $appointment->appointment_id ?>'); openCancelPopup();">
                                <i class="fa-solid fa-ban"></i> Cancel
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No appointments found.</p>
                <?php endif; ?>
            </div>

          

           

    <?php include('components/footer.php'); ?>

    <!-- Cancel Confirmation Popup -->
    <div id="cancelPopup" class="popup-overlay">
        <div class="popup-box">
            <p><i class="fa-solid fa-circle-question"></i> Are you sure you want to cancel this appointment?</p>
            <p><strong>Note:</strong> Refund should be collected by visiting the Vet Center.</p>
            <div class="popup-actions">
                <button onclick="confirmCancel()" class="popup-btn confirm"><i class="fa-solid fa-check"></i> Yes, Cancel</button>
                <button onclick="closeCancelPopup()" class="popup-btn"><i class="fa-solid fa-times"></i> No</button>
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

        function rescheduleAppointment(vet_id) {
            document.getElementById("vet_id_"+vet_id).value = vet_id;
            document.getElementById("rescheduleAppointmentForm_"+vet_id).submit();
        }
    </script>
</body>
</html>