<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetavailability.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petownerappointments.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Vet Appointments</title>
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar3.php'); ?>

        <div class="main-content">
            <h1>Your Upcoming Appointments</h1>
            <div class="calendar" id="calendar"></div>

            <div id="appointmentsSection" class="appointments-container">
                <h2>Select a date to view appointments</h2>
                <div id="appointmentsList"></div>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Update Appointment Details when completed-->
    <form id="completeAppointmentForm" action="<?= ROOT ?>/VetAvailability/completeAppointment" method="POST" style="display: none;">
            <input type="hidden" name="appointment_id" id="appointment_id">
    </form>

    <?php include('components/footer.php'); ?>

        <script>
            let appointmentsData = <?php echo json_encode($vetAppointmentDetails); ?>;
            let vetAvailabilityDetails = <?= json_encode($vetAvailabilityDetails); ?>;

            function formatDate(date) {
            return date.toISOString().split('T')[0]; // Get only the YYYY-MM-DD part
            }

            function generateCalendar() {
                const calendar = document.getElementById("calendar");
                calendar.innerHTML = "";

                let today = new Date();
                today.setHours(0, 0, 0, 0); // Set to midnight to remove time portion

                for (let i = 0; i < 7; i++) {
                    let date = new Date(today);
                    date.setDate(today.getDate() + i);

                    const dayElement = document.createElement("div");
                    dayElement.className = "calendar-day";
                    dayElement.textContent = date.toLocaleDateString("en-US", { weekday: "short", day: "numeric" });

                    dayElement.onclick = () => {
                        document.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected-day'));
                        dayElement.classList.add('selected-day');
                        displayAppointmentsForDate(formatDate(date));
                    };

                    calendar.appendChild(dayElement);
                }
            }

            function displayAppointmentsForDate(dateString) {
                const appointmentsSection = document.getElementById("appointmentsList");
                appointmentsSection.innerHTML = "";

                // Filter appointments data by comparing the dateString (which is in YYYY-MM-DD format)
                const filtered = appointmentsData.filter(app => {
                    // Convert the app.appointment_date to YYYY-MM-DD format without time
                    let appointmentDate = new Date(app.appointment_date);
                    appointmentDate.setHours(0, 0, 0, 0);  // Set to midnight
                    return formatDate(appointmentDate) === dateString;
                });

                if (filtered.length === 0) {
                    appointmentsSection.innerHTML = "<p>No appointments for this day.</p>";
                    return;
                }

                // Group appointments by avl_id (availability slot) and then by appointment time
                const grouped = {};
                filtered.forEach(app => {
                    const avlId = app.avl_id;
                    const timeSlot = app.appointment_time;

                    if (!grouped[avlId]) {
                        grouped[avlId] = {};
                    }
                    if (!grouped[avlId][timeSlot]) {
                        grouped[avlId][timeSlot] = [];
                    }
                    grouped[avlId][timeSlot].push(app);
                });

                // Loop through each grouped avl_id (availability slot) to get the start and end times
                for (let avlId in grouped) {
                    // Fetch the availability details (start_time, end_time) for this avl_id
                    const availability = vetAvailabilityDetails.find(avl => avl.avl_id == avlId);

                    if (!availability) continue; // Skip if availability details are not found

                    const avlSlotDiv = document.createElement("div");
                    avlSlotDiv.className = "time-slot";

                    // Display the start and end times of the availability slot
                    avlSlotDiv.innerHTML = `<strong>Slot: ${availability.start_time} - ${availability.end_time}</strong>`;

                    // Render time slots under each availability slot
                    for (let timeSlot in grouped[avlId]) {
                        const timeSlotDiv = document.createElement("div");
                        timeSlotDiv.className = "time-slot-details";
                        timeSlotDiv.innerHTML = `<strong>Time: ${timeSlot}</strong>`;

                        grouped[avlId][timeSlot].forEach(app => {
                            const card = document.createElement("div");
                            card.className = "appointment-card";
                            card.innerHTML = `
                                <p>Pet Owner: <strong>${app.f_name} ${app.l_name}</strong></p>
                                <div class="appointment-actions">
                                    <button class="complete-btn" onclick="markAsCompleted('${app.appointment_id}')">Completed</button>
                                    <button class="cancel-btn" onclick="cancelAppointment('${app.appointment_id}')">Cancel</button>
                                </div>
                            `;
                            timeSlotDiv.appendChild(card);
                        });

                        avlSlotDiv.appendChild(timeSlotDiv);
                    }

                    appointmentsSection.appendChild(avlSlotDiv);
                }
            }



            function markAsCompleted(appointment_id) {
                document.getElementById("appointment_id").value = appointment;
                document.getElementById("completeAppointmentForm").submit();
            }

            function cancelAppointment(ownerId, time) {
                alert(`Cancelled appointment for Owner ID ${ownerId} at ${time}.`);
            }

            generateCalendar();
        </script>
    </body>
</html>











