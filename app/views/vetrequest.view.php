<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetrequest.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">

    

</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <div class="sidebar">
            
            <ul>
                <li><a href="<?=ROOT?>/vetdash">Dashboard</a></li>
                <li><a href="<?=ROOT?>/vetprofile">My Profile</a></li>
                <li><a href="<?=ROOT?>/vetappoinment">Upcoming Appointments</a></li>
                <li><a href="<?=ROOT?>/vetrequest">Appointment Requests</a></li>    
                <li><a href="<?=ROOT?>/vettreatedpet">View Pets</a></li>
                <li><a href="<?=ROOT?>/vetprescription">Prescriptions</a></li>
                <li><a href="<?=ROOT?>/vetavailability">Update Availability</a></li>
                <li><a href="<?=ROOT?>/vetmedrequest">Request to Add Medicine</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="overview-cards">
                <div class="appoinement-requests">
                    <h1>Appoinment Requests</h1>
                        <!-- Each card will have its own appointment details -->
                        <div class="card" id="appointmentreq1">
                        <h3>Appointment Request 1</h3>
                        <button class="btn-dashboard" onclick="openPopup('Max', '2024-11-20', '10:00 AM', 'appointmentreq1')">View Details</button>
                    </div>

                    <div class="card" id="appointmentreq2">
                        <h3>Appointment Request 2</h3>
                        <button class="btn-dashboard" onclick="openPopup('Bella', '2024-11-21', '2:00 PM', 'appointmentreq2')">View Details</button>
                    </div>

                    <div class="card" id="appointmentreq3">
                        <h3>Appointment Request 3</h3>
                        <button class="btn-dashboard" onclick="openPopup('Rex', '2024-11-22', '4:00 PM', 'appointmentreq3')">View Details</button>
                    </div>

                    <div class="card" id="appointmentreq4">
                        <h3>Appointment Request 4</h3>
                        <button class="btn-dashboard" onclick="openPopup('Luna', '2024-11-23', '11:00 AM', 'appointmentreq4')">View Details</button>
                    </div>

                    <div class="card" id="appointmentreq5">
                        <h3>Appointment Request 5</h3>
                        <button class="btn-dashboard" onclick="openPopup('Liya', '2024-11-25', '12:00 AM', 'appointmentreq5')">View Details</button>
                    </div>

                        <!-- Popup structure -->
                        <div id="appointmentPopup" class="popup">
                            <div class="popup-content">
                                <h3>Appointment Details</h3>
                                <p><strong>Pet Name:</strong> <span id="petName">Max</span></p>
                                <p><strong>Appointment Date:</strong> <span id="appointmentDate">2024-11-20</span></p>
                                <p><strong>Time:</strong> <span id="appointmentTime">10:00 AM</span></p>

                            <div class="popup-buttons">
                                <button class="btn-accept" >Accept</button>
                                <button class="btn-decline" onclick="declineAppointment()">Decline</button>
                            </div>
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
        function openPopup(petName, appointmentDate, appointmentTime, appointmentId) {
            document.getElementById("petName").textContent = petName;
            document.getElementById("appointmentDate").textContent = appointmentDate;
            document.getElementById("appointmentTime").textContent = appointmentTime;
            document.getElementById("appointmentPopup").style.display = "flex";

            currentAppointmentId = appointmentId; // Set the correct current appointment ID
        }

        function closePopup() {
            document.getElementById("appointmentPopup").style.display = "none";
        }

        function declineAppointment() {
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