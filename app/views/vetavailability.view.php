<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetavailability.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petownerappointments.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Vet Availability</title>

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

        .calendar-day.unavailable {
            background-color: #c35b64;
            color: #721c24;
        }

        .calendar-day.frozen {
            background-color: #f0f0f0;
            color: #aaa;
            cursor: not-allowed;
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
        }

        .time-slot-container h2 {
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
    <?php include ('components/sidebar3.php'); ?>
    

        <!-- Main content area -->
        <div class="main-content">
            <h1>Veterinary Surgeon Availability</h1>
            <div class="calendar-controls">
                <button class="btn" onclick="prevMonth()">Previous</button>
                <span class="monthyear" id="monthYear"></span>
                <button class="btn" onclick="nextMonth()">Next</button>
            </div>
            
            <div class="calendar" id="calendar">
                <!-- Calendar days will be dynamically generated here -->
            </div>

            <!-- Time slot container -->
            <div id="timeSlotContainer" class="time-slot-container">
                <!-- Time slots will be dynamically generated here -->
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

            const interval = 15; // Fixed 15-minute interval
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

                const slotElement = document.createElement("div");
                slotElement.className = "time-slot";
                slotElement.textContent = `${formattedTime} - ${formattedNextTime}`;
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

        // Initialize calendar on page load
        generateCalendar();
    </script>
</body>
</html>