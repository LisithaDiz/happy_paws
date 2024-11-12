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
            <h3>Vet Dashboard</h3>
            <ul>
                <li><a href="<?=ROOT?>/vet/profile">My Profile</a></li>
                <li><a href="<?=ROOT?>/vet/confirmed-appointments">Upcoming Appointments</a></li>
                <li><a href="<?=ROOT?>/vet/received-appointments">Appointment Requests</a></li>    
                <li><a href="<?=ROOT?>/vet/view-patients">View Patients</a></li>
                <li><a href="<?=ROOT?>/vet/prescriptions">Prescriptions</a></li>
                <li><a href="<?=ROOT?>/vet/settings">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="overview-cards">
                <div class="appoinement-requests">
                    <h1>------------------------------Appoinment Requests------------------------------</h1>
                    <div class="card">
                        <h3>Appointment Request 1</h3>
                        <button class="btn-dashboard" onclick="openPopup()">View Details</button>
                       
                    </div>

                    <div class="card">
                        <h3>Appointment Request 2</h3>
                        <button class="btn-dashboard" onclick="openPopup()">View Details</button>
                       
                    </div>

                    <div class="card">
                        <h3>Appointment Request 3</h3>
                        <button class="btn-dashboard" onclick="openPopup()">View Details</button>
                       
                    </div>
                    <div class="card">
                        <h3>Appointment Request 4</h3>
                        <button class="btn-dashboard" onclick="openPopup()">View Details</button>
                       
                    </div>

                    <div id="appointmentPopup" class="popup">
                        <div class="popup-content">
                            <h3>Appointment Details</h3>
                            <p><strong>Appointment Date:</strong> 2024-11-20</p>
                            <p><strong>Time:</strong> 10:00 AM</p>
                            <p><strong>Patient Name:</strong> Max</p>
                            <div class="popup-buttons">
                                <button class="btn-accept">Accept</button>
                                <button class="btn-decline">Decline</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

       

    </div>
    
    <?php include ('components/footer.php'); ?>
   
    <script src="<?=ROOT?>/assets/js/script.js"></script>

    <script>
        // JavaScript to handle opening and closing the popup
        function openPopup() {
            document.getElementById("appointmentPopup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("appointmentPopup").style.display = "none";
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