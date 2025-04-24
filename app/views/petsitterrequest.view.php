<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petsitterrequest.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <title>Happy Paws - My Requests</title>

    

</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar_pet_sitter.php'); ?>

        <div class="main-content">
            <div class="overview-cards">
                <div class="appoinement-requests">
                    <h1>Requests</h1>
                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <div class="card" id="appointment-<?= $appointment->appointment_id ?>">
                                <h3>Request for <?= htmlspecialchars($appointment->pet_name) ?></h3>
                                <p>Date: <?= date('Y-m-d', strtotime($appointment->day_of_appointment)) ?></p>
                                <button class="btn-dashboard" onclick="openPopup(<?= $appointment->appointment_id ?>, '<?= htmlspecialchars($appointment->pet_name) ?>', '<?= $appointment->day_of_appointment ?>')">
                                    View Details
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No pending requests found.</p>
                    <?php endif; ?>

                    <!-- Popup structure -->
                    <div id="appointmentPopup" class="popup">
                        <div class="popup-content">
                            <h3>Booking Details</h3>
                            <p><strong>Pet Name:</strong> <span id="petName"></span></p>
                            <p><strong>Appointment Date:</strong> <span id="appointmentDate"></span></p>
                            <input type="hidden" id="currentAppointmentId">
                            <div class="popup-buttons">
                                <button class="btn-accept" onclick="acceptAppointment()">Accept</button>
                                <button class="btn-decline" onclick="declineAppointment()">Decline</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

       

    </div>
    
    <?php include ('components/footer_mini.php'); ?>
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->

    <script>
        function openPopup(appointmentId, petName, appointmentDate) {
            document.getElementById("petName").textContent = petName;
            document.getElementById("appointmentDate").textContent = appointmentDate;
            document.getElementById("currentAppointmentId").value = appointmentId;
            document.getElementById("appointmentPopup").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("appointmentPopup").style.display = "none";
        }

        function acceptAppointment() {
            const appointmentId = document.getElementById("currentAppointmentId").value;
            updateAppointmentStatus(appointmentId, 'confirmed');
        }

        function declineAppointment() {
            const appointmentId = document.getElementById("currentAppointmentId").value;
            updateAppointmentStatus(appointmentId, 'declined');
        }

        function updateAppointmentStatus(appointmentId, status) {
            const formData = new FormData();
            formData.append('appointment_id', appointmentId);
            formData.append('status', status);

            fetch('<?= ROOT ?>/PetSitterRequest/updateStatus', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const card = document.getElementById(`appointment-${appointmentId}`);
                    if (card) {
                        card.remove();
                    }
                    closePopup();
                    alert('Appointment status updated successfully');
                } else {
                    alert(data.message || 'Failed to update appointment status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the appointment status');
            });
        }

        // Close popup when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById("appointmentPopup")) {
                closePopup();
            }
        }
    </script>
   
</body>
</html>