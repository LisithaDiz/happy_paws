<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petsitteravailability.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            z-index: 1000;
            animation: fadeIn 0.3s ease-in;
        }

        .notification.success {
            background-color: #4CAF50;
        }

        .notification.error {
            background-color: #f44336;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-20px); }
        }
    </style>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <?php include ('components/sidebar.php'); ?>
    
    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="<?=ROOT?>/PetSitterDashboard">Dashboard</a></li>
                <li><a href="<?=ROOT?>/PetSitterProfile">My Profile</a></li>
                <li><a href="<?=ROOT?>/PetSitterRequest">View Requests</a></li>
                <li><a href="<?=ROOT?>/PetSitterAccepted">Accepted Requests</a></li>    
                <li><a href="<?=ROOT?>/PetSitterPet">View Pets</a></li>
                <li><a href="<?=ROOT?>/PetSitterAvailabilityUpdate">Update Availability</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h1>Update Your Availability</h1>
            <div class="calendar-controls">
                <button class="btn" onclick="prevMonth()">Previous</button>
                <span class="monthyear" id="monthYear"></span>
                <button class="btn" onclick="nextMonth()">Next</button>
            </div>
            
            <div class="calendar" id="calendar">
                <!-- Calendar days will be dynamically generated here -->
            </div>

            <!-- Availability Form -->
            <div id="availabilityForm" class="availability-form" style="display: none;">
                <h3>Set Availability for <span id="selectedDate"></span></h3>
                <form id="updateAvailabilityForm">
                    <input type="hidden" id="dateInput" name="date">
                    <div class="form-group">
                        <label for="slots">Number of Slots:</label>
                        <input type="number" id="slots" name="slots" min="1" max="10" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price per Slot (Rs.):</label>
                        <input type="number" id="price" name="price" min="0" step="0.01" required>
                    </div>
                    <div class="form-buttons">
                        <button type="submit" class="btn">Update Availability</button>
                        <button type="button" class="btn btn-secondary" onclick="hideForm()">Cancel</button>
                    </div>
                </form>
            </div>

            <div id="notification" class="notification" style="display: none;"></div>
        </div>
    </div>


    <script>
        let currentDate = new Date();
        const availabilityData = <?= json_encode($availabilityData) ?>;
        const availabilityMap = new Map(availabilityData.map(item => [item.day, item]));

        function generateCalendar() {
            const calendar = document.getElementById("calendar");
            const monthYear = document.getElementById("monthYear");
            calendar.innerHTML = "";
            
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            monthYear.textContent = `${currentDate.toLocaleString("default", { month: "long" })} ${year}`;

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

                if (availabilityMap.has(date)) {
                    const data = availabilityMap.get(date);
                    dayElement.classList.add("available");
                    const info = document.createElement("div");
                    info.className = "availability-info";
                    info.innerHTML = `
                        <div>${data.number_of_slots} slots</div>
                        <div>Rs. ${data.price_per_slot || 0}/slot</div>
                    `;
                    dayElement.appendChild(info);
                }

                dayElement.onclick = () => showAvailabilityForm(date, dayElement);
                calendar.appendChild(dayElement);
            }
        }

        function showAvailabilityForm(date, element) {
            const form = document.getElementById("availabilityForm");
            const selectedDate = document.getElementById("selectedDate");
            const dateInput = document.getElementById("dateInput");
            const slotsInput = document.getElementById("slots");
            const priceInput = document.getElementById("price");

            // Highlight selected day
            const selectedDays = document.querySelectorAll(".calendar-day.selected");
            selectedDays.forEach(day => day.classList.remove("selected"));
            element.classList.add("selected");

            // Format date for display (e.g., "April 23, 2023")
            const displayDate = new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            selectedDate.textContent = displayDate;
            dateInput.value = date; // Store the ISO format date for submission
            form.style.display = "block";

            if (availabilityMap.has(date)) {
                const data = availabilityMap.get(date);
                slotsInput.value = data.number_of_slots;
                priceInput.value = data.price_per_slot;
            } else {
                slotsInput.value = "1";
                priceInput.value = "";
            }

            // Scroll to form
            form.scrollIntoView({ behavior: 'smooth' });
        }

        document.getElementById("updateAvailabilityForm").addEventListener("submit", function(e) {
            e.preventDefault();
            
            const form = e.target;
            const formData = new FormData(form);
            
            fetch('<?= ROOT ?>/PetSitterAvailabilityUpdate/updateAvailability', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, true);
                    
                    // Update the calendar display without reloading the page
                    const date = formData.get('date');
                    const slots = formData.get('slots');
                    const price = formData.get('price');
                    
                    // Update the availability map
                    availabilityMap.set(date, {
                        day: date,
                        number_of_slots: slots,
                        price_per_slot: price
                    });
                    
                    // Regenerate the calendar
                    generateCalendar();
                    hideForm();
                } else {
                    showNotification(data.message || 'Failed to update availability', false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while updating availability', false);
            });
        });

        function prevMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            generateCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar();
        }

        function hideForm() {
            const form = document.getElementById("availabilityForm");
            form.style.display = "none";
        }

        function showNotification(message, isSuccess) {
            const notification = document.getElementById("notification");
            notification.textContent = message;
            notification.className = isSuccess ? "notification success" : "notification error";
            notification.style.display = "block";
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.animation = "fadeOut 0.3s ease-out";
                setTimeout(() => {
                    notification.style.display = "none";
                    notification.style.animation = "";
                }, 300);
            }, 3000);
        }

        // Initialize calendar on page load
        generateCalendar();
    </script>
</body>
</html> 