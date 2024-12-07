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
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
    <?php include ('components/sidebar3.php'); ?>


        <div class="main-content">
            
            <div class="overview-cards">
                <div class="appoinement-requests">
                    <h1>Appointments</h1>

                    <?php if (isset($appointmentDetails) && !empty($appointmentDetails)):?>
                        <?php foreach ($appointmentDetails as $appointment):?>
                        <!-- Each card will have its own appointment details -->
                        <div class="card" id="appointment<?= htmlspecialchars($appointment->pet_id) ?>">
                            <h3>Appointment for <?= htmlspecialchars($appointment->pet_name) ?></h3>
                            <button class="btn-dashboard" onclick="openPopup('<?= htmlspecialchars($appointment->pet_name) ?>' , 
                            '<?= htmlspecialchars($appointment->startTime) ?>' , 
                            '<?= htmlspecialchars($appointment->endTime) ?>' , 
                            'appointment<?= htmlspecialchars($appointment->pet_id) ?>')">View Details</button>
                        </div>
                        <?php endforeach ?>
                    <?php else: ?>
                        <p>No appointment details found.</p>
                    <?php endif; ?>


                    <!-- Popup structure -->
                    <div id="appointmentPopup" class="popup">
                        <div class="popup-content">
                            <h3>Appointment Details</h3>
                            <p><strong>Pet Name:</strong> <span id="petName">Max</span></p>
                            <p><strong>Appointment Date:</strong> <span id="startTime">2024-11-20</span></p>
                            <p><strong>Time:</strong> <span id="endTime">10:00 AM</span></p>
                            
                            <!-- Completed button in the popup -->
                            <button class="btn-completed" onclick="completeAppointment()">Completed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>
<!-- 
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->

    <script>
        let currentAppointmentId = null;

            // Function to open the popup with dynamic details
            function openPopup(petName, startTime, endTime, appointmentId) {
                document.getElementById("petName").textContent = petName;
                document.getElementById("startTime").textContent = startTime;
                document.getElementById("endTime").textContent = endTime;
                document.getElementById("appointmentPopup").style.display = "flex";

                currentAppointmentId = appointmentId; // Set the correct current appointment ID
            }

            function closePopup() {
                document.getElementById("appointmentPopup").style.display = "none";
            }

            function completeAppointment() {
                if (currentAppointmentId) {
                    const card = document.getElementById(currentAppointmentId);
                    if (card) {
                        card.remove(); // Remove the appointment card from the dashboard
                    }
                    closePopup(); // Close the popup after marking as completed
                }
            }

            // Optional: Close the popup when clicking outside the popup content
            window.onclick = function(event) {
                if (event.target == document.getElementById("appointmentPopup")) {
                    closePopup();
                }
            }

        
    </script>
</body>
</html>
