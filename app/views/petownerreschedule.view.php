<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petownerbookvet.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">

</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include ('components/sidebar.php'); ?>

        <div class="main-content">
            <h1>Book Appointment</h1>
            <div class="calendar" id="calendar"></div>
            <div id="timeSlotContainer" class="time-slot-container"></div>
        </div>
    </div>

    <!-- Booking Confirmation Popup -->
    <div class="popup-overlay" id="confirmationPopup">
        <div class="popup">
            <h3>Confirm Booking</h3>
            <p id="confirmText"></p>
            <button class="confirm-btn" onclick="confirmBooking()">Confirm</button>
            <button class="cancel-btn" onclick="closePopup()">Cancel</button>
            <div id="bookingDetailsText"></div>
        </div>
    </div>

    <!-- Hidden Form for Booking Details -->
    <form id="bookingForm" action="<?= ROOT ?>/petOwnerreschedule/reschedulevet" method="POST" style="display: none;">
        <input type="hidden" name="avl_id" id="avl_id">
        <input type="hidden" name="vet_id" id="vet_id">
        <input type="hidden" name="date" id="date">
        <input type="hidden" name="exact_time" id="exact_time">
    </form>


    <?php include('components/footer.php'); ?>

    <script>
    let currentDate = new Date();
    const vetAvailability = <?= json_encode($vetAvailabilityDetails); ?>;
    let selectedSlot = null;

    function generateCalendar() {
        const calendar = document.getElementById("calendar");
        calendar.innerHTML = "";

        for (let i = 0; i < 7; i++) {
            const date = new Date();
            date.setDate(currentDate.getDate() + i);
            const dayName = date.toLocaleString('en-US', { weekday: 'long' });

            const isAvailable = vetAvailability.some(entry => entry.day_of_week === dayName);

            const dayElement = document.createElement("div");
            dayElement.className = `calendar-day ${isAvailable ? 'available' : ''}`;
            dayElement.textContent = date.toDateString();

            if (isAvailable) {
                dayElement.onclick = () => handleDateClick(dayName, date);
            }

            calendar.appendChild(dayElement);
        }
    }

    function handleDateClick(dayName, date) {
        const timeSlotContainer = document.getElementById("timeSlotContainer");
        timeSlotContainer.innerHTML = `<h2>Available Slots for ${date.toDateString()}</h2>`;
        selectedSlot = null;

        const errorMsg = document.createElement("div");
        errorMsg.id = "errorMessage";
        errorMsg.className = "error-message";
        timeSlotContainer.appendChild(errorMsg);

        const availableTimes = vetAvailability.filter(entry => entry.day_of_week === dayName);
        availableTimes.forEach(entry => {
            const timeRange = `${entry.start_time} - ${entry.end_time}`;
            const slotElement = document.createElement("div");
            slotElement.className = "time-slot";
            slotElement.textContent = `${timeRange} (${entry.available_slots} slots available)`;

            slotElement.onclick = () => {
                document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
                slotElement.classList.add('selected');
                selectedSlot = {
                    ...entry,
                    date: date.toISOString().split('T')[0]  // fixed here
                };
                document.getElementById("errorMessage").textContent = "";
            };

            timeSlotContainer.appendChild(slotElement);
        });

        const bookButton = document.createElement("button");
        bookButton.className = "book-btn";
        bookButton.textContent = "Book Vet";
        bookButton.onclick = handleBooking;
        timeSlotContainer.appendChild(bookButton);
    }

    function handleBooking() {
        if (!selectedSlot) {
            document.getElementById("errorMessage").textContent = "Please select a time slot.";
            return;
        }

        const [startHour, startMinute] = selectedSlot.start_time.split(":").map(Number);
        const [endHour, endMinute] = selectedSlot.end_time.split(":").map(Number);

        const startTime = new Date();
        startTime.setHours(startHour, startMinute, 0, 0);

        const endTime = new Date();
        endTime.setHours(endHour, endMinute, 0, 0);

        const totalMinutes = (endTime - startTime) / (1000 * 60);
        const slotDuration = totalMinutes / selectedSlot.number_of_appointments;

        const appointmentTime = new Date(startTime.getTime() + selectedSlot.booked_slots * slotDuration * 60000);
        const hours = appointmentTime.getHours().toString().padStart(2, '0');
        const minutes = appointmentTime.getMinutes().toString().padStart(2, '0');
        const exactTime = `${hours}:${minutes}`;

        window.exactTime = exactTime;
        window.formattedDate = selectedSlot.date;  // already correct

        const confirmText = `
            Vet: Dr. ${selectedSlot.f_name} ${selectedSlot.l_name}
            Date: ${selectedSlot.date}
            Time: ${exactTime}
        `;
        document.getElementById("confirmText").innerText = confirmText;
        document.getElementById("confirmationPopup").style.display = "flex";
    }

    function confirmBooking() {
        document.getElementById("avl_id").value = selectedSlot.avl_id;
        document.getElementById("vet_id").value = selectedSlot.vet_id;
        document.getElementById("date").value = window.formattedDate;
        document.getElementById("exact_time").value = window.exactTime;
        document.getElementById("bookingForm").submit();
    }

    function closePopup() {
        document.getElementById("confirmationPopup").style.display = "none";
        document.getElementById("bookingDetailsText").innerText = "";
        document.querySelector(".confirm-btn").style.display = "inline-block";
        document.querySelector(".cancel-btn").textContent = "Cancel";
    }

    generateCalendar();
</script>

</body>
</html>