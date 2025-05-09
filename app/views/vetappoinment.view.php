<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetappointment.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Vet Appointment</title>
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar3.php'); ?>

        <div class="main-content">
            <div class="overview-cards">
                <div class="appointment-requests">
                    <h1>Appointments</h1>

                    <?php if (isset($appointmentDetails) && !empty($appointmentDetails)): ?>
                        <?php foreach ($appointmentDetails as $appointment): ?>
                            <div class="card" id="card-<?= htmlspecialchars($appointment->appointment_id) ?>">
                                <h3>Appointment for <?= htmlspecialchars($appointment->pet_name) ?></h3>
                                <button class="btn-dashboard" onclick="openPopup('<?= htmlspecialchars($appointment->pet_name) ?>', 
                                    '<?= htmlspecialchars($appointment->startTime) ?>', 
                                    '<?= htmlspecialchars($appointment->endTime) ?>', 
                                    '<?= htmlspecialchars($appointment->appointment_id) ?>')">View Details</button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No appointment details found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup Structure -->
    <div id="appointmentPopup" class="popup" style="display: none;">
        <div class="popup-content">
            <h3>Appointment Details</h3>
            <p><strong>Pet Name:</strong> <span id="petName"></span></p>
            <p><strong>Start Time:</strong> <span id="startTime"></span></p>
            <p><strong>End Time:</strong> <span id="endTime"></span></p>

            <form id="completeForm" method="POST" action="<?= ROOT ?>/VetAppoinment/appointmentStatus">
                <input type="hidden" name="appointment_id" id="appointmentIdInput">
                <button type="submit" class="btn-completed">Completed</button>
            </form>
            <button onclick="closePopup()" class="btn-close">Close</button>
        </div>
    </div>

    <?php include('components/footer.php'); ?>

    <script>
        let currentAppointmentId = null;

        function openPopup(petName, startTime, endTime, appointmentId) {
            console.log("Popup triggered for:", petName, startTime, endTime, appointmentId);

            // Set the dynamic details in the popup
            document.getElementById("petName").textContent = petName;
            document.getElementById("startTime").textContent = startTime;
            document.getElementById("endTime").textContent = endTime;

            // Update the hidden input for the appointment ID
            document.getElementById("appointmentIdInput").value = appointmentId;

            // Display the popup
            document.getElementById("appointmentPopup").style.display = "flex";

            // Track the current appointment ID
            currentAppointmentId = appointmentId;
        }

        function closePopup() {
            document.getElementById("appointmentPopup").style.display = "none";
        }

        // Optional: Close the popup when clicking outside the popup content
        window.onclick = function(event) {
            const popup = document.getElementById("appointmentPopup");
            if (event.target === popup) {
                closePopup();
            }
        };
    </script>
</body>
</html>

