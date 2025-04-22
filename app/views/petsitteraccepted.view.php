<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetappointment.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
</head>
<body>
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="<?=ROOT?>/PetSitterDashboard">Dashboard</a></li>
                <li><a href="<?=ROOT?>/PetSitterProfile">My Profile</a></li>
                <li><a href="<?=ROOT?>/PetSitterRequest">View Requests</a></li>
                <li><a href="<?=ROOT?>/PetSitterAccepted">Accepted Requests</a></li>    
                <li><a href="<?=ROOT?>/PetSitterPet">View Pets</a></li>
                <li><a href="<?=ROOT?>/PetSitterAvailability">Update Availability</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="overview-cards">
                <div class="appoinement-requests">
                    <h1>Accepted Appointments</h1>
                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <div class="card" id="appointment-<?= $appointment->appointment_id ?>">
                                <h3>Appointment for <?= htmlspecialchars($appointment->pet_name) ?></h3>
                                <p>Date: <?= date('Y-m-d', strtotime($appointment->day_of_appointment)) ?></p>
                                <button class="btn-dashboard" onclick="openPopup(<?= $appointment->appointment_id ?>, '<?= htmlspecialchars($appointment->pet_name) ?>', '<?= $appointment->day_of_appointment ?>')">
                                    View Details
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No accepted appointments found.</p>
                    <?php endif; ?>

                    <!-- Popup structure -->
                    <div id="appointmentPopup" class="popup">
                        <div class="popup-content">
                            <h3>Appointment Details</h3>
                            <p><strong>Pet Name:</strong> <span id="petName"></span></p>
                            <p><strong>Appointment Date:</strong> <span id="appointmentDate"></span></p>
                            <input type="hidden" id="currentAppointmentId">
                            <button class="btn-completed" onclick="completeAppointment()">Mark as Completed</button>
                            <button class="btn-close" onclick="closePopup()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>

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

        function completeAppointment() {
            const appointmentId = document.getElementById("currentAppointmentId").value;
            const formData = new FormData();
            formData.append('appointment_id', appointmentId);

            fetch('<?= ROOT ?>/PetSitterAccepted/completeAppointment', {
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
                    alert('Appointment marked as completed');
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