<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecenteravailability.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Happy Paws - My Availability</title>

</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
    <?php include ('components/sidebar_care_center.php'); ?>


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

                <div class="changes-summary" id="changesSummary" style="display: none;">
                    <h3>Pending Changes</h3>
                    <div id="changesList"></div>
                    <button class="btn confirm-btn" onclick="confirmChanges()">Confirm Changes</button>
                    <button class="btn cancel-btn" onclick="cancelChanges()">Cancel Changes</button>
                </div>
        </div>

    </div>


    <script>
        let currentDate = new Date();
        const unavailableDates = new Set(<?= json_encode($unavailableDates ?? []) ?>);
        const pendingChanges = new Map(); // Store pending changes

        function isDateInPast(dateStr) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const date = new Date(dateStr);
            return date < today;
        }

        function toggleAvailability(date, element) {
            // Check if the date is in the past
            if (isDateInPast(date)) {
                alert('You can only mark dates from today onwards as unavailable.');
                return;
            }

            const isUnavailable = unavailableDates.has(date);
            const newState = !isUnavailable;
            
            // Store the change in pendingChanges
            pendingChanges.set(date, newState);
            
            // Update visual state
            if (newState) {
                element.classList.remove("available");
                element.classList.add("unavailable");
            } else {
                element.classList.remove("unavailable");
                element.classList.add("available");
            }

            // Show changes summary
            updateChangesSummary();
        }

        function updateChangesSummary() {
            const summaryDiv = document.getElementById('changesSummary');
            const changesList = document.getElementById('changesList');
            
            if (pendingChanges.size > 0) {
                summaryDiv.style.display = 'block';
                changesList.innerHTML = '';
                
                pendingChanges.forEach((isUnavailable, date) => {
                    const changeItem = document.createElement('div');
                    changeItem.className = 'change-item';
                    changeItem.textContent = `${date}: ${isUnavailable ? 'Unavailable' : 'Available'}`;
                    changesList.appendChild(changeItem);
                });
            } else {
                summaryDiv.style.display = 'none';
            }
        }

        async function confirmChanges() {
            try {
                for (const [date, isUnavailable] of pendingChanges) {
                    const response = await fetch('<?=ROOT?>/CareCenterAvailability/updateAvailability', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            date: date,
                            isUnavailable: isUnavailable
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to update availability');
                    }

                    // Update the unavailableDates set
                    if (isUnavailable) {
                        unavailableDates.add(date);
                    } else {
                        unavailableDates.delete(date);
                    }
                }

                // Clear pending changes
                pendingChanges.clear();
                updateChangesSummary();
                
                // Show success message
                alert('Changes have been saved successfully!');
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while saving changes. Please try again.');
                // Revert visual changes
                generateCalendar();
            }
        }

        function cancelChanges() {
            // Clear pending changes
            pendingChanges.clear();
            // Revert visual changes
            generateCalendar();
            // Hide changes summary
            document.getElementById('changesSummary').style.display = 'none';
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

                // Check if the date is in the past
                if (isDateInPast(date)) {
                    dayElement.classList.add("past-date");
                    dayElement.style.cursor = "not-allowed";
                    dayElement.style.opacity = "0.5";
                } else {
                    // Check both unavailableDates and pendingChanges for the current state
                    const isUnavailable = unavailableDates.has(date) || 
                                        (pendingChanges.has(date) && pendingChanges.get(date));

                    if (isUnavailable) {
                        dayElement.classList.add("unavailable");
                    } else {
                        dayElement.classList.add("available");
                    }

                    dayElement.onclick = () => toggleAvailability(date, dayElement);
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

    <style>
        .changes-summary {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .change-item {
            padding: 5px;
            margin: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .confirm-btn {
            background-color: #28a745;
            color: white;
            margin-right: 10px;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
        }

        .confirm-btn:hover {
            background-color: #218838;
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }

        .past-date {
            background-color: #f8f9fa !important;
            color: #6c757d !important;
            cursor: not-allowed !important;
        }
    </style>

<?php include ('components/footer_mini.php'); ?>
<!--    
    <script src="<?=ROOT?>/assets/js/script.js"></script> -->
   
</body>
</html>