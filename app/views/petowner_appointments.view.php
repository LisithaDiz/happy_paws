<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
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
            <h1>My Appointments</h1>

            
            <h2>Upcoming Appointments</h2><br/>
            <div class="appointments-list">
                <?php if(!empty($appointmentDetails)): ?>
                    <?php foreach($appointmentDetails as $appointment): ?>
                        <div class="appointment-card">
                            <div class="appointment-details">
                                <p><strong>Vet Name:</strong> <?= htmlspecialchars($appointment->f_name) . ' ' . htmlspecialchars($appointment->l_name) ?></p>
                                <p><strong>Date:</strong> <?= htmlspecialchars($appointment->appointment_date) ?></p>
                                <p><strong>Time:</strong> <?= htmlspecialchars($appointment->appointment_time) ?></p>
                            </div>
                            <a href="<?= ROOT ?>/VetProfile/view/<?= $appointment->vet_id ?>" class="view-vet-btn">View Vet</a>
                            <button class="cancel-btn"
                                onclick="setCancelUrl('<?= ROOT ?>/PetOwner_Appointments/cancelAppointment/<?= $appointment->appointment_id ?>'); openCancelPopup();">
                                Cancel Appointment
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No appointments found.</p>
                <?php endif; ?>
            </div>

            
            <br/><h2>Appointments Cancelled By Veterinary Surgeon</h2><br/>
            <div class="reschedule-appointments-list">
            <?php if(!empty($rescheduleAppontments)): ?>
                <?php foreach($rescheduleAppontments as $appointment): ?>
                    <div class="reschedule-appointment-card">
                        <div class="reschedule-appointment-details">
                            <h2>Appointment Cancelled!</h2>
                            <p><strong>Vet Name:</strong> <?= htmlspecialchars($appointment->f_name) . ' ' . htmlspecialchars($appointment->l_name) ?></p>
                            <p><strong>Old Date:</strong> <?= htmlspecialchars($appointment->appointment_date) ?></p>
                            <p><strong>Old Time:</strong> <?= htmlspecialchars($appointment->appointment_time) ?></p>
                        </div>
                        <a href="<?= ROOT ?>/VetProfile/view/<?= $appointment->vet_id ?>" class="reschedule-view-vet-btn">View Vet</a>
                 
                        <button class="reschedule-cancel-btn" onclick="rescheduleAppointment(<?= $appointment->vet_id?>)" >Reschedule</button>
                        <!-- hidden form -->
                        <form id="rescheduleAppointmentForm_<?= $appointment->vet_id?>" action="<?= ROOT ?>/PetOwner_Reschedule/index" method="POST" style="display: none;">
                            <input type="hidden" name="vet_id" id="vet_id_<?=  $appointment->vet_id?>">
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

            <br/><h2>Appointments Cancelled By You</h2><br/>   
            <div class="cancelled-appointments-list">
                <?php if(!empty($cancelledAppointments)): ?>
                    <?php foreach($cancelledAppointments as $appointment): ?>
                        <div class="cancelled-appointment-card">
                            <div class="cancelled-appointment-details">
                                <p><strong>Vet Name:</strong> <?= htmlspecialchars($appointment->f_name) . ' ' . htmlspecialchars($appointment->l_name) ?></p>
                                <p><strong>Date:</strong> <?= htmlspecialchars($appointment->appointment_date) ?></p>
                                <p><strong>Time:</strong> <?= htmlspecialchars($appointment->appointment_time) ?></p>
                            </div>
                            <a href="<?= ROOT ?>/VetProfile/view/<?= $appointment->vet_id ?>" class="cancelled-view-vet-btn">View Vet</a>
                            <center><p>Appoinment Cancelled</p></center>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    
                <?php endif; ?>
            </div>

        


        </div>
    </div>

    <?php include('components/footer.php'); ?>

    <!-- Cancel Confirmation Popup -->
    <div id="cancelPopup" class="popup-overlay">
        <div class="popup-box">
            <p>Are you sure you want to cancel this appointment?</p>
            <p><strong>Note:</strong> Refund should be collected by visiting the Vet Center.</p>
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

        
        function rescheduleAppointment(vet_id) {
            document.getElementById("vet_id_"+vet_id).value = vet_id;
            document.getElementById("rescheduleAppointmentForm_"+vet_id).submit();
        }
    </script>
</body>
</html>

