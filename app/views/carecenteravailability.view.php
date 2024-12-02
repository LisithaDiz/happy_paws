<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petsitteravailability.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">

    

</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <div class="sidebar">
            <ul>
                <li><a href="<?=ROOT?>/carecenterdash">Dashboard</a></li>
                <li><a href="<?=ROOT?>/carecenterpet">View Pets</a></li>
                <li><a href="<?=ROOT?>/carecentercage">Maintain Cages</a></li>
                <li><a href="<?=ROOT?>/carecenteravailability">Update Availability</a></li>
            </ul>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <h1>Update Your Availability</h1>
                <div class="calendar-controls">
                    <button class="btn" onclick="prevMonth()">Previous</button>
                    <span class ="monthyear"  id="monthYear"></span>
                    <button class="btn" onclick="nextMonth()">Next</button>
                </div>
                
                <div class="calendar" id="calendar">
                    <!-- Calendar days will be dynamically generated here -->
                </div>
        </div>

    </div>


    
    <?php include ('components/footer.php'); ?>

    <script>
        let currentDate = new Date();
        const unavailableDates = new Set(); // Store unavailable dates

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

                if (unavailableDates.has(date)) {
                    dayElement.classList.add("unavailable");
                } else {
                    dayElement.classList.add("available");
                }

                dayElement.onclick = () => toggleAvailability(date, dayElement);
                calendar.appendChild(dayElement);
            }
        }

        function toggleAvailability(date, element) {
            if (unavailableDates.has(date)) {
                unavailableDates.delete(date);
                element.classList.remove("unavailable");
                element.classList.add("available");
            } else {
                unavailableDates.add(date);
                element.classList.remove("available");
                element.classList.add("unavailable");
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
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->
   
</body>
</html>