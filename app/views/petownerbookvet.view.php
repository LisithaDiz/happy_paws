<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetavailability.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            padding: 20px;
        }

        .calendar-day {
            padding: 10px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .calendar-day.available {
            background-color: #fae3e3;
            color: rgb(77, 77, 77);
        }

        .calendar-day.selected {
            background-color: #f5c6cb;
            color: #333;
        }

        .time-slot-container {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .time-slot {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fae3e3;
            color: rgb(77, 77, 77);
            cursor: pointer;
        }

        .time-slot.selected {
            background-color: #c35b64;
            color: white;
        }

        .book-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #c35b64;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 100%;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .popup {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            text-align: center;
        }

        .popup button {
            margin: 10px 5px;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-btn {
            background-color: #4CAF50;
            color: white;
        }

        .cancel-btn {
            background-color: #c35b64;
            color: white;
        }

        #bookingDetailsText {
            margin-top: 15px;
            white-space: pre-wrap;
            color: #333;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include ('components/sidebar.php'); ?>

        <div class="main-content">
            <h1>Veterinary Surgeon Availability</h1>
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
    <form id="bookingForm" action="<?= ROOT ?>/petOwnerBookVet/bookvet" method="POST" style="display: none;">
        <input type="hidden" name="avl_id" id="avl_id">
        <input type="hidden" name="vet_id" id="vet_id">
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
                        date: date.toDateString()
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

            const confirmText = `
            Vet: Dr. ${selectedSlot.f_name} ${selectedSlot.l_name}
            Date: ${selectedSlot.date}
            Time: ${selectedSlot.start_time} - ${selectedSlot.end_time}
            `;
            document.getElementById("confirmText").innerText = confirmText;
            document.getElementById("confirmationPopup").style.display = "flex";
        }

        function confirmBooking() {
            // Populate only the necessary hidden fields
            document.getElementById("avl_id").value = selectedSlot.avl_id;
            document.getElementById("vet_id").value = selectedSlot.vet_id;

            // Submit the form
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



