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

            <div class="cancelled-appointments-container" id="cancelledAppointmentsSection" style="display: none;">
                <h2>Cancelled Appointments</h2>
                <div id="cancelledAppointmentsList"></div>
            </div>

        </div>
    </div>

    <!-- hidden form for view profile -->
    <form id="viewProfileForm" action="<?= ROOT ?>/vetview_petownerprofile/index" method="POST" style="display: none;">
        <input type="hidden" name="owner_id" id="owner_id">
    </form>

    <!-- hidden form for complete appointment -->
    <form id="completeAppointmentForm" action="<?= ROOT ?>/VetAvailability/completeAppointment" method="POST" style="display: none;">
        <input type="hidden" name="appointment_id" id="appointment_id">
    </form>

    <!-- hidden form for cancel appointment -->
    <form id="cancelAppointmentForm" action="<?= ROOT ?>/VetAvailability/cancelAppointment" method="POST" style="display: none;">
        <input type="hidden" name="appointment_id" id="cancel_appointment_id">
    </form>

    <?php include('components/footer.php'); ?>

    <script>
        let appointmentsData = <?= json_encode($vetAppointmentDetails ?? []); ?>;
        let vetAvailabilityDetails = <?= json_encode($vetAvailabilityDetails ?? []); ?>;
        let cancelledAppointmentsData = <?= json_encode($cancelledAppointmentDetails ?? []); ?>;

        console.log("Loaded Cancelled Appointments:", cancelledAppointmentsData);

        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }

        function generateCalendar() {
            const calendar = document.getElementById("calendar");
            calendar.innerHTML = "";

            let today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let i = 0; i < 7; i++) {
                let date = new Date(today);
                date.setDate(today.getDate() + i);

                const dayElement = document.createElement("div");
                dayElement.className = "calendar-day";
                dayElement.textContent = date.toLocaleDateString("en-US", { weekday: "short", day: "numeric" });

                dayElement.onclick = () => {
                    document.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected-day'));
                    dayElement.classList.add('selected-day');

                    const selectedDate = formatDate(date);
                    displayAppointmentsForDate(selectedDate);
                    displayCancelledAppointments(selectedDate);
                };

                calendar.appendChild(dayElement);
            }
        }

        function displayAppointmentsForDate(dateString) {
            const appointmentsSection = document.getElementById("appointmentsList");
            appointmentsSection.innerHTML = "";

            const filtered = appointmentsData.filter(app => {
                let appointmentDate = new Date(app.appointment_date);
                appointmentDate.setHours(0, 0, 0, 0);
                return formatDate(appointmentDate) === dateString;
            });

            if (filtered.length === 0) {
                appointmentsSection.innerHTML = "<p>No appointments for this day.</p>";
                return;
            }

            const grouped = {};
            filtered.forEach(app => {
                const avlId = app.avl_id;
                const timeSlot = app.appointment_time;
                if (!grouped[avlId]) grouped[avlId] = {};
                if (!grouped[avlId][timeSlot]) grouped[avlId][timeSlot] = [];
                grouped[avlId][timeSlot].push(app);
            });

            for (let avlId in grouped) {
                const availability = vetAvailabilityDetails.find(avl => avl.avl_id == avlId);
                if (!availability) continue;

                const avlSlotDiv = document.createElement("div");
                avlSlotDiv.className = "time-slot";
                avlSlotDiv.innerHTML = `<strong>Slot: ${availability.start_time} - ${availability.end_time}</strong>`;

                for (let timeSlot in grouped[avlId]) {
                    const timeSlotDiv = document.createElement("div");
                    timeSlotDiv.className = "time-slot-details";
                    timeSlotDiv.innerHTML = `<strong>Time: ${timeSlot}</strong>`;

                    grouped[avlId][timeSlot].forEach(app => {
                        const card = document.createElement("div");
                        card.className = "appointment-card";

                        if (app.status === 'cancelled') {
                            card.style.backgroundColor = '#e0e0e0';
                            card.style.color = '#555';
                            card.innerHTML = `
                                <p>Pet Owner: <strong>${app.f_name} ${app.l_name}</strong></p>
                                <p><em>Appointment Cancelled</em></p>
                            `;
                        } else {
                            card.innerHTML = `
                                <p>Pet Owner: <strong>${app.f_name} ${app.l_name}</strong></p>
                                <div class="appointment-actions">
                                    <button class="complete-btn" onclick="viewOwnerProfile('${app.owner_id}')">view profile</button>
                                    <button class="complete-btn" onclick="markAsCompleted('${app.appointment_id}')">Completed</button>
                                    <button class="cancel-btn" onclick="cancelAppointment('${app.appointment_id}')">Cancel</button>
                                </div>
                            `;
                        }

                        timeSlotDiv.appendChild(card);
                    });

                    avlSlotDiv.appendChild(timeSlotDiv);
                }

                appointmentsSection.appendChild(avlSlotDiv);
            }
        }

        function displayCancelledAppointments(dateString) {
    const cancelledSection = document.getElementById("cancelledAppointmentsSection");
    const cancelledList = document.getElementById("cancelledAppointmentsList");

    const filtered = cancelledAppointmentsData.filter(app => {
        let appointmentDate = new Date(app.appointment_date);
        appointmentDate.setHours(0, 0, 0, 0);
        return formatDate(appointmentDate) === dateString;
    });

    if (filtered.length === 0) {
        cancelledSection.style.display = "none";
        return;
    }

    cancelledSection.style.display = "block";
    cancelledList.innerHTML = ""; // clear previous

    filtered.forEach(app => {
        const availability = vetAvailabilityDetails.find(avl => avl.avl_id == app.avl_id);
        const timeSlotText = availability
            ? `${availability.start_time} - ${availability.end_time}`
            : "Time Slot Not Available";

        const card = document.createElement("div");
        card.className = "appointment-card cancelled-card";
        card.innerHTML = `
            <p>Pet Owner: <strong>${app.f_name} ${app.l_name}</strong></p>
            <p><strong>Time Slot:</strong> ${timeSlotText}</p>
            <p><strong>Appointment Time:</strong> ${app.appointment_time}</p>
            <p><em>Cancelled by you</em></p>
            
        `;

        cancelledList.appendChild(card);
    });
}

        function viewOwnerProfile(owner_id) {
            document.getElementById("owner_id").value = owner_id;
            document.getElementById("viewProfileForm").submit();
        }

        function markAsCompleted(appointment_id) {
            document.getElementById("appointment_id").value = appointment_id;
            document.getElementById("completeAppointmentForm").submit();
        }

        function cancelAppointment(appointment_id) {
            document.getElementById("cancel_appointment_id").value = appointment_id;
            document.getElementById("cancelAppointmentForm").submit();
        }

        generateCalendar();
    </script>
</body>
</html>
















