<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecentercage.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Cage Management</title>
</head>
<body>
    <?php include ('components/nav.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="<?=ROOT?>/carecenterdash">Dashboard</a></li>
                <li><a href="<?=ROOT?>/carecenterprofile">My Profile</a></li>
                <li><a href="<?=ROOT?>/carecenterpet">View Pets</a></li>
                <li><a href="<?=ROOT?>/carecentercage">Maintain Cages</a></li>
                <li><a href="<?=ROOT?>/carecenteravailability">Update Availability</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Cage Management</h1>
            <p>Manage cages for dogs, cats, and birds efficiently. Select a date to view cage availability.</p>

            <!-- Date Selection -->
            <div class="date-picker">
                <label for="cage-date">Select Date:</label>
                <input type="date" id="cage-date" onchange="fetchCageData()">
            </div>

            <!-- Cage Summary -->
            <div class="cage-summary">
                <div class="cage-card">
                    <h2>Dogs</h2>
                    <p>Total Cages: <span id="total-dog-cages">0</span></p>
                    <p>Remaining Cages: <span id="remaining-dog-cages">0</span></p>
                    <button class="update-btn" onclick="showPopup('dog')">Update</button>
                </div>
                <div class="cage-card">
                    <h2>Cats</h2>
                    <p>Total Cages: <span id="total-cat-cages">0</span></p>
                    <p>Remaining Cages: <span id="remaining-cat-cages">0</span></p>
                    <button class="update-btn" onclick="showPopup('cat')">Update</button>
                </div>
                <div class="cage-card">
                    <h2>Birds</h2>
                    <p>Total Cages: <span id="total-bird-cages">0</span></p>
                    <p>Remaining Cages: <span id="remaining-bird-cages">0</span></p>
                    <button class="update-btn" onclick="showPopup('bird')">Update</button>
                </div>
            </div>

             <!-- Popup Form -->
            <div id="popupForm" class="popup-form">
                <div class="form-content">
                    <h2>Update Cages</h2>
                    <label for="totalCages">Total Cages:</label>
                    <input type="number" id="totalCages" />
                    <label for="remainingCages">Remaining Cages:</label>
                    <input type="number" id="remainingCages" />
                    <div class="form-actions">
                        <button class="btn" onclick="updateCages()">Submit</button>
                        <button class="btn cancel-btn" onclick="closePopup()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include ('components/footer.php'); ?>

    <script>
        // Fetch Cage Data based on the selected date
        function fetchCageData() {
            const selectedDate = document.getElementById('cage-date').value;
            if (!selectedDate) return;

            fetch(`<?=ROOT?>/api/cages?date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-dog-cages').textContent = data.dogs.total;
                    document.getElementById('remaining-dog-cages').textContent = data.dogs.remaining;
                    document.getElementById('total-cat-cages').textContent = data.cats.total;
                    document.getElementById('remaining-cat-cages').textContent = data.cats.remaining;
                    document.getElementById('total-bird-cages').textContent = data.birds.total;
                    document.getElementById('remaining-bird-cages').textContent = data.birds.remaining;
                })
                .catch(error => console.error('Error fetching cage data:', error));
        }

        let currentType = ''; // To store the selected cage type

        // Show popup form for updating cages
        function showPopup(type) {
            currentType = type; // Set current type (dog, cat, bird)
            document.getElementById("popupForm").style.display = "flex"; // Show popup
        }

        // Close the popup form
        function closePopup() {
            document.getElementById("popupForm").style.display = "none"; // Hide popup
            currentType = ''; // Reset type
        }

        // Update cages on form submission
        function updateCages() {
            const totalCages = document.getElementById("totalCages").value;
            const remainingCages = document.getElementById("remainingCages").value;

            if (currentType && totalCages && remainingCages) {
                // Update values for the selected cage type
                document.getElementById(`${currentType}Total`).textContent = totalCages;
                document.getElementById(`${currentType}Remaining`).textContent = remainingCages;

                alert(`${currentType.charAt(0).toUpperCase() + currentType.slice(1)} cages updated!`);
                closePopup(); // Close the popup
            } else {
                alert("Please fill out both fields.");
            }
        }



    </script>
</body>
</html>
