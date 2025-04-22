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
            cursor: default;
            transition: background-color 0.3s ease;
        }

        .calendar-day.clickable {
            background-color: #fae3e3;
            color: rgb(77, 77, 77);
            cursor: pointer;
        }

        .calendar-day.clickable:hover {
            background-color: #f5c6cb;
        }

        /* Popup Styling */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .popup h2 {
            margin-bottom: 10px;
        }

        .popup .time-slot {
            display: block;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fae3e3;
            color: rgb(77, 77, 77);
            text-align: center;
        }

        .popup .close-btn {
            display: block;
            margin-top: 10px;
            padding: 5px 10px;
            background: #c35b64;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .calendar-header button {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .calendar-header button:hover {
            background-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar3.php'); ?>

        <div class="main-content">
            <h1> Your Availability </h1>
 
            <div class="calendar-header">
                <button onclick="changeMonth(-1)">Prev</button>
                <h2 id="calendarTitle"></h2>
                <button onclick="changeMonth(1)">Next</button>
            </div>
            <div class="calendar" id="calendar"></div>
        </div>
    </div>

    <div id="availabilityPopup" class="popup">
        <h2>Available Hours</h2>
        <div id="timeSlots"></div>
        <button class="close-btn" onclick="closePopup()">Close</button>
    </div>

    <?php include('components/footer.php'); ?>

    <script>
    let vetAvailabilityDetails = <?= json_encode($vetAvailabilityDetails); ?>;

    let currentDate = new Date();

    function generateCalendar() {
        const calendar = document.getElementById("calendar");
        calendar.innerHTML = "";

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const firstDayOfMonth = new Date(year, month, 1);
        const lastDayOfMonth = new Date(year, month + 1, 0);
        const totalDays = lastDayOfMonth.getDate();
        const lastClickableDate = new Date(today);
        lastClickableDate.setDate(today.getDate() + 6);

        for (let i = 1; i <= totalDays; i++) {
            const date = new Date(year, month, i);
            date.setHours(0, 0, 0, 0);
            const dayElement = document.createElement("div");
            dayElement.className = "calendar-day";
            dayElement.textContent = date.toLocaleDateString("en-US", { weekday: "short", day: "numeric" });

            if (date.getTime() >= today.getTime() && date <= lastClickableDate) {
                dayElement.classList.add("clickable");
                dayElement.onclick = () => showAvailabilityPopup(date);
            }

            calendar.appendChild(dayElement);
        }

        document.getElementById("calendarTitle").textContent = `${currentDate.toLocaleString("en-US", { month: "long" })} ${currentDate.getFullYear()}`;
    }

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        generateCalendar();
    }

    function showAvailabilityPopup(date) {
        const popup = document.getElementById("availabilityPopup");
        const timeSlotsContainer = document.getElementById("timeSlots");
        timeSlotsContainer.innerHTML = "";

        const selectedDay = date.toLocaleDateString('en-US', { weekday: 'long' });
        const hours = vetAvailabilityDetails.filter(slot => slot.day_of_week === selectedDay);

        if (hours.length === 0) {
            timeSlotsContainer.innerHTML = "<p>No available hours</p>";
        } else {
            hours.forEach(slot => {
                const timeSlot = document.createElement("div");
                timeSlot.className = "time-slot";
                timeSlot.textContent = `${formatTime(slot.start_time)} - ${formatTime(slot.end_time)} (${slot.number_of_appointments} slots)`;
                timeSlotsContainer.appendChild(timeSlot);
            });
        }

        popup.style.display = "block";
    }

    function formatTime(timeString) {
        const [hour, minute] = timeString.split(":").map(Number);
        const period = hour >= 12 ? "PM" : "AM";
        return `${hour % 12 || 12}:${minute.toString().padStart(2, '0')} ${period}`;
    }

    function closePopup() {
        document.getElementById("availabilityPopup").style.display = "none";
    }

    generateCalendar();
</script>
</body>
</html>





