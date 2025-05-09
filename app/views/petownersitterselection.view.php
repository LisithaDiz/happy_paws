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
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/sidebar.css">
    <style>
        /* Your calendar and modal styles remain unchanged for clarity */
    </style>
</head>
<body>
    <?php include('components/nav2.php'); ?>
    <div class="dashboard-container">
        <?php include('components/sidebar.php'); ?>
        <div class="main-content">
            <div class="header-actions">
                <h1>Pet Sitter Availability</h1>
                <a href="<?=ROOT?>/PetOwnerAppointments" class="btn btn-primary my-appointments-btn">
                    <i class="fas fa-calendar-alt"></i> My Appointments
                </a>
            </div>
            
            <div class="calendar-controls">
                <button class="btn" onclick="prevMonth()">Previous</button>
                <span class="monthyear" id="monthYear"></span>
                <button class="btn" onclick="nextMonth()">Next</button>
            </div>
            <div class="calendar" id="calendar"></div>
            <div class="selected-dates">
                <h3>Selected Dates</h3>
                <div class="selected-dates-list" id="selectedDatesList"></div>
                <div style="margin-top: 20px; text-align: center;">
                    <button class="btn btn-primary" onclick="placeOrder()">Place Order</button>
                </div>
            </div>
        </div>
    </div>

    <div id="petSelectionModal" class="modal">
        <div class="modal-content">
            <h3>Select Your Pet</h3>
            <?php if (empty($pets)): ?>
                <div class="alert alert-warning">
                    You don't have any pets registered. Please add a pet first.
                    <br>
                    <a href="<?=ROOT?>/PetAdd" class="btn btn-primary mt-2">Add a Pet</a>
                </div>
            <?php else: ?>
                <form id="petSelectionForm">
                    <div class="form-group">
                        <label for="pet_id">Choose a Pet:</label>
                        <select name="pet_id" id="pet_id" required class="form-control">
                            <option value="">Select a pet</option>
                            <?php foreach ($pets as $pet): ?>
                                <option value="<?= $pet['pet_id'] ?>"><?= htmlspecialchars($pet['pet_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="selected-dates-summary">
                        <h4>Selected Dates:</h4>
                        <div id="modalSelectedDates"></div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        <button type="button" class="btn btn-secondary" onclick="closePetSelectionModal()">Cancel</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .selected-dates-summary {
            margin: 15px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .mt-2 { margin-top: 10px; }
        .mt-3 { margin-top: 15px; }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }
    </style>

    <script>
        const currentDate = new Date();
        const selectedDates = new Set();
        const sitterId = <?= json_encode($sitter_id) ?>;
        const availabilityMap = new Map(<?= json_encode($availabilityData) ?>.map(item => [item.day, item.number_of_slots]));

        function handleDateClick(el, date) {
            selectedDates.has(date) ? selectedDates.delete(date) : selectedDates.add(date);
            el.classList.toggle("selected");
            updateSelectedDatesDisplay();
        }

        function updateSelectedDatesDisplay() {
            const container = document.getElementById("selectedDatesList");
            container.innerHTML = "";

            [...selectedDates].sort((a, b) => new Date(a) - new Date(b)).forEach(date => {
                const el = document.createElement("div");
                el.className = "selected-date-item";
                el.innerHTML = `${formatDate(new Date(date))} (${availabilityMap.get(date) || 0} slots)
                                <span class="remove-date" onclick="removeDate('${date}')">×</span>`;
                container.appendChild(el);
            });
        }

        function removeDate(date) {
            selectedDates.delete(date);
            updateSelectedDatesDisplay();
            generateCalendar();
        }

        function formatDate(date) {
            return date.toLocaleDateString("en-US", { year: "numeric", month: "long", day: "numeric" });
        }

        function generateCalendar() {
            const calendar = document.getElementById("calendar");
            const monthYear = document.getElementById("monthYear");
            const year = currentDate.getFullYear(), month = currentDate.getMonth();
            calendar.innerHTML = "";
            monthYear.textContent = `${currentDate.toLocaleString("default", { month: "long" })} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) calendar.appendChild(document.createElement("div"));

            for (let day = 1; day <= daysInMonth; day++) {
                const date = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
                const el = document.createElement("div");
                el.className = "calendar-day";
                el.dataset.date = date;

                const dateNumber = document.createElement("div");
                dateNumber.className = "date-number";
                dateNumber.textContent = day;
                el.appendChild(dateNumber);

                if (availabilityMap.has(date)) {
                    const slots = availabilityMap.get(date);
                    const slotInfo = document.createElement("div");
                    slotInfo.className = "slots-available";
                    slotInfo.textContent = `${slots} slots`;
                    el.appendChild(slotInfo);
                    el.classList.add("available");
                    el.onclick = () => handleDateClick(el, date);
                } else {
                    el.classList.add("frozen");
                }

                if (selectedDates.has(date)) el.classList.add("selected");

                calendar.appendChild(el);
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

        function placeOrder() {
            if (!selectedDates.size) {
                alert("Please select at least one date.");
                return;
            }

            const modal = document.getElementById("petSelectionModal");
            const modalSelectedDates = document.getElementById("modalSelectedDates");
            
            // Update selected dates in modal
            modalSelectedDates.innerHTML = [...selectedDates]
                .sort((a, b) => new Date(a) - new Date(b))
                .map(date => `<div>${formatDate(new Date(date))}</div>`)
                .join('');
            
            modal.style.display = "block";
        }

        function closePetSelectionModal() {
            document.getElementById("petSelectionModal").style.display = "none";
        }

        document.getElementById("petSelectionForm").onsubmit = function(e) {
            e.preventDefault();
            const petId = document.getElementById("pet_id").value;

            if (!petId) {
                alert("Please select a pet.");
                return;
            }

            const dates = [...selectedDates].map(encodeURIComponent).join(',');

            const url = `<?= ROOT ?>/PetOwnerSitterSelection/placeOrder?sitter_id=${sitterId}&pet_id=${petId}&dates=${dates}`;
            window.location.href = url;
            console.log(url);   
        };


        generateCalendar();
    </script>
</body>
</html>
