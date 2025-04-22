<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetprescription.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Vet Prescriptions</title>
    <style>
        /* Styling for selected medicines with dosage and frequency inputs */
        #medicineListDisplay li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .dosage-input,
        .frequency-input {
            flex: 1;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .dosage-input::placeholder,
        .frequency-input::placeholder {
            font-size: 0.9em;
            color: #999;
        }
    </style>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar3.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <div class="overview-cards">
                <h1>Prescriptions</h1>
                
                <!-- Prescription List -->
                <div class="prescription-card" id="prescription1">
                    <div class="pet-info">
                        <img src="<?=ROOT?>/assets/images/background3.jpeg" alt="Buddy" class="pet-photo">
                        <div>
                            <h3>Buddy</h3>
                            <p>Age: 2 years</p>
                        </div>
                    </div>
                    <button class="btn-dashboard" onclick="openPrescriptionForm('Buddy', 2, 'prescription1')">Fill Prescription</button>
                </div>

                <div class="prescription-card" id="prescription2">
                    <div class="pet-info">
                        <img src="<?=ROOT?>/assets/images/background2.jpeg" alt="Bella" class="pet-photo">
                        <div>
                            <h3>Bella</h3>
                            <p>Age: 3 years</p>
                        </div>
                    </div>
                    <button class="btn-dashboard" onclick="openPrescriptionForm('Bella', 3, 'prescription2')">Fill Prescription</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Prescription Form Popup -->
    <div id="prescriptionPopup" class="popup" style="display:none;">
        <div class="popup-content">
            <h3>Fill Prescription</h3>
            
            <!-- Select Medicine Dropdown with Searchable Input -->
            <div class="medicine-select">
                <label for="medicineDropdown">Select Medicines:</label>
                <input type="text" id="medicineDropdown" oninput="filterMedicines()" placeholder="Search for medicine...">
                <ul id="medicineList" class="dropdown-list">
                    <!-- Medicines to choose from (Example List) -->
                    <li onclick="selectMedicine('Amoxicillin')">Amoxicillin</li>
                    <li onclick="selectMedicine('Cephalexin')">Cephalexin</li>
                    <li onclick="selectMedicine('Doxycycline')">Doxycycline</li>
                    <li onclick="selectMedicine('Metronidazole')">Metronidazole</li>
                    <li onclick="selectMedicine('Ibuprofen')">Ibuprofen</li>
                </ul>
            </div>
            
            <!-- Selected Medicines Display -->
            <div id="selectedMedicines">
                <h4>Selected Medicines:</h4>
                <ul id="medicineListDisplay"></ul>
            </div>

            <!-- Special Note Section -->
            <br/>
            <label for="specialNote">Special Note (if any):</label>
            <textarea id="specialNote" rows="3"></textarea>

            <!-- Submit Button -->
            <button class="btn-completed" onclick="submitPrescription()">Submit</button>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>

    <script>
        let selectedMedicines = []; // Example: [{name: "Amoxicillin", dosage: "250mg", frequency: "Twice a day"}]

        // Open Prescription Form
        function openPrescriptionForm(petName, petAge, cardId) {
            document.getElementById("prescriptionPopup").style.display = "flex";
            document.getElementById("prescriptionPopup").setAttribute("data-card-id", cardId); // Store the card ID
        }

       

        function filterMedicines() {
            const searchValue = document.getElementById("medicineDropdown").value.toLowerCase();
            const medicineItems = document.querySelectorAll("#medicineList li");

            medicineItems.forEach((item) => {
                item.style.display = item.innerText.toLowerCase().includes(searchValue) ? "block" : "none";
            });
        }

        function selectMedicine(medicine) {
            if (!selectedMedicines.some(med => med.name === medicine)) {
                selectedMedicines.push({ name: medicine, dosage: "", frequency: "" });
                displaySelectedMedicines();
            }
        }

        function displaySelectedMedicines() {
            const medicineListDisplay = document.getElementById("medicineListDisplay");
            medicineListDisplay.innerHTML = "";

            selectedMedicines.forEach((medicine, index) => {
                const li = document.createElement("li");

                li.innerHTML = `
                    <span>${medicine.name}</span>
                    <input type="text" placeholder="Dosage (e.g., 250mg)" class="dosage-input" data-index="${index}">
                    <input type="text" placeholder="Frequency (e.g., Twice a day)" class="frequency-input" data-index="${index}">
                `;

                medicineListDisplay.appendChild(li);
            });
        }

        function closePopup() {
            document.getElementById("prescriptionPopup").style.display = "none";
            selectedMedicines = [];
            document.getElementById("medicineListDisplay").innerHTML = "";
            document.getElementById("medicineDropdown").value = "";
            document.getElementById("specialNote").value = "";
        }

        function submitPrescription(event) {
            event.preventDefault(); // Prevent page reload on form submission

            const specialNote = document.getElementById("specialNote").value;

            // Get dosage and frequency inputs
            const dosageInputs = document.querySelectorAll(".dosage-input");
            const frequencyInputs = document.querySelectorAll(".frequency-input");

            dosageInputs.forEach(input => {
                const index = input.getAttribute("data-index");
                selectedMedicines[index].dosage = input.value;
            });

            frequencyInputs.forEach(input => {
                const index = input.getAttribute("data-index");
                selectedMedicines[index].frequency = input.value;
            });

            console.log("Selected Medicines with Details:", selectedMedicines);
            console.log("Special Note:", specialNote);

            closePopup();
            alert("Prescription submitted successfully!");
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("prescriptionPopup")) {
                closePopup();
            }
        }; 
       

        // Close Popup and Clear Selected Medicines
        function closePopup() {
            document.getElementById("prescriptionPopup").style.display = "none";
            selectedMedicines = [];
            document.getElementById("medicineListDisplay").innerHTML = "";
            document.getElementById("medicineDropdown").value = "";
            document.getElementById("specialNote").value = "";
        }
  

       
    </script>
</body>
</html>

