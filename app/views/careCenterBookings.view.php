<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecenterbooking.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <title>Happy Paws - My Bookings</title>
    <style>
        .all-bookings-container {
            margin-top: 2rem;
            padding: 1rem;
        }

        .bookings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .sort-options select {
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #ddd;
            background-color: white;
            font-size: 0.9rem;
        }

        .bookings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .booking-card {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .booking-info {
            margin-bottom: 1rem;
        }

        .booking-info p {
            margin: 0.5rem 0;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .booking-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .view-btn, .cancel-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .view-btn {
            background-color: #4CAF50;
            color: white;
        }

        .cancel-btn {
            background-color: #f44336;
            color: white;
        }

        .view-btn:hover, .cancel-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar_care_center.php'); ?>

        <div class="main-content">
            <h1>Care Center Bookings</h1>
            
            <div class="calendar-controls">
                <button class="btn" onclick="prevMonth()">Previous</button>
                <span class="monthyear" id="monthYear"></span>
                <button class="btn" onclick="nextMonth()">Next</button>
            </div>
            
            <div class="calendar" id="calendar"></div>

            <div class="all-bookings-container">
                <div class="bookings-header">
                    <h2>All Bookings</h2>
                    <div class="sort-options">
                        <select id="sortBy" onchange="sortBookings()">
                            <option value="date_desc">Date (Newest First)</option>
                            <option value="date_asc">Date (Oldest First)</option>
                            <option value="status">Status</option>
                            <option value="pet">Pet Name</option>
                        </select>
                    </div>
                </div>
                <div class="bookings-grid" id="bookingsGrid">
                    <?php if (!empty($bookingDetails)): ?>
                        <?php foreach ($bookingDetails as $booking): ?>
                            <div class="booking-card" data-date="<?= strtotime($booking->booking_date) ?>" data-status="<?= $booking->status ?>" data-pet="<?= $booking->pet_name ?>">
                                <div class="booking-info">
                                    <p><strong>Pet:</strong> <?= htmlspecialchars($booking->pet_name) ?></p>
                                    <p><strong>Owner:</strong> <?= htmlspecialchars($booking->owner_name) ?></p>
                                    <p><strong>Cage:</strong> <?= htmlspecialchars($booking->cage_name) ?></p>
                                    <p><strong>Date:</strong> <?= date('Y-m-d', strtotime($booking->booking_date)) ?></p>
                                    <p><strong>Status:</strong> <span class="status-badge status-<?= strtolower($booking->status) ?>"><?= htmlspecialchars($booking->status) ?></span></p>
                                    <?php if (!empty($booking->special_requirements)): ?>
                                        <p><strong>Special Requirements:</strong> <?= htmlspecialchars($booking->special_requirements) ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="booking-actions">
                                    <button class="view-btn" onclick="viewOwnerProfile('<?= $booking->owner_id ?>')">View Owner Profile</button>
                                    <?php if ($booking->status !== 'Cancelled'): ?>
                                        <button class="cancel-btn" onclick="cancelBooking('<?= $booking->booking_id ?>')">Cancel Booking</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No bookings found.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div id="bookingsSection" class="bookings-container">
                <h2>Select a date to view bookings</h2>
                <div id="bookingsList"></div>
            </div>

            <div class="cancelled-bookings-container" id="cancelledBookingsSection" style="display: none;">
                <h2>Cancelled Bookings</h2>
                <div id="cancelledBookingsList"></div>
            </div>
        </div>
    </div>

    <!-- hidden form for view pet owner profile -->
    <form id="viewProfileForm" action="<?= ROOT ?>/carecenterview_petownerprofile/index" method="POST" style="display: none;">
        <input type="hidden" name="owner_id" id="owner_id">
    </form>

    <!-- hidden form for cancel booking -->
    <form id="cancelBookingForm" action="<?= ROOT ?>/CareCenterBookings/cancelBooking" method="POST" style="display: none;">
        <input type="hidden" name="booking_id" id="cancel_booking_id">
    </form>

    <script>
        let bookingsData = <?= json_encode($bookingDetails ?? []); ?>;
        let cancelledBookingsData = <?= json_encode($cancelledBookingDetails ?? []); ?>;
        let currentDate = new Date();

        function formatDate(date) {
            return date.toISOString().split('T')[0];
        }

        function isDateInPast(dateStr) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const date = new Date(dateStr);
            return date < today;
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
                emptyDay.className = "calendar-day empty";
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
                    // Check if there are bookings for this day
                    const hasBookings = bookingsData.some(booking => {
                        const bookingDate = new Date(booking.booking_date);
                        return formatDate(bookingDate) === date;
                    });

                    if (hasBookings) {
                        dayElement.classList.add("has-bookings");
                    }

                    dayElement.onclick = () => {
                        document.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected-day'));
                        dayElement.classList.add('selected-day');
                        displayBookingsForDate(date);
                    };
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

        function displayBookingsForDate(dateString) {
            const bookingsSection = document.getElementById("bookingsList");
            bookingsSection.innerHTML = "";

            const filtered = bookingsData.filter(booking => {
                let bookingDate = new Date(booking.booking_date);
                bookingDate.setHours(0, 0, 0, 0);
                return formatDate(bookingDate) === dateString;
            });

            if (filtered.length === 0) {
                bookingsSection.innerHTML = "<p>No bookings for this day.</p>";
                return;
            }

            filtered.forEach(booking => {
                const card = document.createElement("div");
                card.className = "booking-card";
                card.innerHTML = `
                    <p>Pet: <strong>${booking.pet_name}</strong></p>
                    <p>Owner: <strong>${booking.owner_name}</strong></p>
                    <p>Cage: <strong>${booking.cage_name}</strong></p>
                    <p>Booking Date: <strong>${new Date(booking.booking_date).toLocaleDateString()}</strong></p>
                    <p>Special Requirements: <strong>${booking.special_requirements || 'None'}</strong></p>
                    <div class="booking-actions">
                        <button class="view-btn" onclick="viewOwnerProfile('${booking.owner_id}')">View Owner Profile</button>
                        <button class="cancel-btn" onclick="cancelBooking('${booking.booking_id}')">Cancel Booking</button>
                    </div>
                `;
                bookingsSection.appendChild(card);
            });
        }

        function viewOwnerProfile(owner_id) {
            document.getElementById("owner_id").value = owner_id;
            document.getElementById("viewProfileForm").submit();
        }

        function cancelBooking(booking_id) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                document.getElementById("cancel_booking_id").value = booking_id;
                document.getElementById("cancelBookingForm").submit();
            }
        }

        function sortBookings() {
            const sortBy = document.getElementById("sortBy").value;
            const bookingsGrid = document.getElementById("bookingsGrid");
            const bookings = Array.from(bookingsGrid.children);

            bookings.sort((a, b) => {
                const dateA = new Date(a.getAttribute("data-date")).getTime();
                const dateB = new Date(b.getAttribute("data-date")).getTime();
                const statusA = a.getAttribute("data-status").toLowerCase();
                const statusB = b.getAttribute("data-status").toLowerCase();
                const petA = a.getAttribute("data-pet").toLowerCase();
                const petB = b.getAttribute("data-pet").toLowerCase();

                if (sortBy === "date_desc") {
                    return dateB - dateA;
                } else if (sortBy === "date_asc") {
                    return dateA - dateB;
                } else if (sortBy === "status") {
                    return statusA.localeCompare(statusB);
                } else if (sortBy === "pet") {
                    return petA.localeCompare(petB);
                }
                return 0;
            });

            bookings.forEach(booking => bookingsGrid.appendChild(booking));
        }

        // Initialize calendar on page load
        generateCalendar();
    </script>
    <?php include ('components/footer_mini.php'); ?>
</body>
</html>
