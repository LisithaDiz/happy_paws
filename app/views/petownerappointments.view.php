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

    <?php include('components/footer.php'); ?>

    <script>
        let currentDate = new Date();

        // Convert PHP data to JavaScript
        const vetAvailability = <?= json_encode($vetAvailabilityDetails); ?>;

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

            const availableTimes = vetAvailability.filter(entry => entry.day_of_week === dayName);

            availableTimes.forEach(entry => {
                const timeRange = `${entry.start_time} - ${entry.end_time}`;
                const slotElement = document.createElement("div");
                slotElement.className = "time-slot";
                slotElement.textContent = `${timeRange} (${entry.available_slots} slots available)`;
                timeSlotContainer.appendChild(slotElement);
            });

            const bookButton = document.createElement("button");
            bookButton.className = "book-btn";
            bookButton.textContent = "Book Vet";
            bookButton.onclick = () => alert("Booking confirmed!");
            timeSlotContainer.appendChild(bookButton);
        }

        generateCalendar();
    </script>
</body>
</html>

