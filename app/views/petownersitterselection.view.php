<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetavailability.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petownerappointments.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/sidebar.css">

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
            background-color: #fae3e3; /* Light pink for available days */
            color: rgb(77, 77, 77);
        }

        .calendar-day.unavailable {
            background-color: #c35b64; /* Light red for unavailable days */
            color: #721c24;
        }

        .calendar-day.frozen {
            background-color: #f0f0f0; /* Gray for frozen dates */
            color: #aaa;
            cursor: not-allowed;
        }

        .calendar-day.selected {
            background-color: #f5c6cb; /* Highlight selected date */
            color: #333;
        }


    </style>
</head>
<body>
    <?php include('components/nav.php'); ?>
    <div class="dashboard-container">
        <?php
        include 'components/renderSidebar.php';
        echo renderSidebar(ROOT, $petowner);
        ?>

        <!-- Main content area -->
        <div class="main-content">
            <h1>Pet Sitter Availability</h1>
            <div class="calendar-controls">
                <button class="btn" onclick="prevMonth()">Previous</button>
                <span class="monthyear" id="monthYear"></span>
                <button class="btn" onclick="nextMonth()">Next</button>
            </div>
            
            <div class="calendar" id="calendar">
            </div>



        </div>
    </div>

    <?php include('components/footer.php'); ?>

    <script>
        let currentDate = new Date();
        const unavailableDates = new Set(["2024-11-25", "2024-11-26"]); // Example unavailable dates
        const frozenDates = new Set(["2024-11-27", "2024-11-28"]); // Example frozen dates

        function generateTimeSlots(selectedDate) {
            const timeSlotContainer = document.getElementById("timeSlotContainer");
            timeSlotContainer.innerHTML = ""; // Clear previous time slots

            const interval = parseInt(document.getElementById("timeInterval").value); // Get selected interval
            const startTime = 8 * 60; // 8:00 AM in minutes
            const endTime = 17 * 60; // 5:00 PM in minutes

            const heading = document.createElement("h2");
            heading.textContent = `Available Time Slots for ${selectedDate}`;
            timeSlotContainer.appendChild(heading);

            for (let time = startTime; time < endTime; time += interval) {
                const hours = Math.floor(time / 60);
                const minutes = time % 60;
                const formattedTime = `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
                const nextTime = time + interval;
                const nextHours = Math.floor(nextTime / 60);
                const nextMinutes = nextTime % 60;
                const formattedNextTime = `${String(nextHours).padStart(2, "0")}:${String(nextMinutes).padStart(2, "0")}`;

                const slotElement = document.createElement("button");
                slotElement.className = "time-slot";
                slotElement.textContent = `${formattedTime} - ${formattedNextTime}`;

                // Handle click on a time slot
                slotElement.onclick = () => {
                    alert(`You selected ${formattedTime} - ${formattedNextTime} on ${selectedDate}`);
                };

                timeSlotContainer.appendChild(slotElement);
            }
        }

        function handleDateClick(dayElement, date) {
            // Highlight the selected date
            const calendarDays = document.querySelectorAll(".calendar-day");
            calendarDays.forEach((day) => day.classList.remove("selected"));
            dayElement.classList.add("selected");

            // Generate time slots for the selected date
            generateTimeSlots(date);
        }

        function generateCalendar() {
            const calendar = document.getElementById("calendar");
            const monthYear = document.getElementById("monthYear");
            calendar.innerHTML = ""; // Clear the calendar
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            // Update month and year in header
            monthYear.textContent = `${currentDate.toLocaleString("default", { month: "long" })} ${year}`;

            // Get first and last days of the month
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Add empty slots for the previous month
            for (let i = 0; i < firstDay; i++) {
                const emptyDay = document.createElement("div");
                calendar.appendChild(emptyDay);
            }

            // Add days of the current month
            for (let day = 1; day <= daysInMonth; day++) {
                const date = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
                const dayElement = document.createElement("div");
                dayElement.className = "calendar-day";
                dayElement.textContent = day;

                if (frozenDates.has(date)) {
                    dayElement.classList.add("frozen");
                } else if (unavailableDates.has(date)) {
                    dayElement.classList.add("unavailable");
                } else {
                    dayElement.classList.add("available");
                    dayElement.onclick = () => handleDateClick(dayElement, date);
                }

                calendar.appendChild(dayElement);
            }
        }

        function prevMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar();
        }

        function updateTimeSlots() {
            const selectedDate = document.querySelector(".calendar-day.selected");
            if (selectedDate) {
                generateTimeSlots(selectedDate.dataset.date);
            }
        }

        // Initialize calendar on page load
        generateCalendar();
    </script>
</body>
</html>
