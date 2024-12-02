<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetprescription.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Vet Prescriptions</title>

    

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

        <!-- Popup Modal -->
        

        <!-- Prescription Form Popup -->
        <div id="prescriptionPopup" class="popup">
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
                        <li onclick="selectMedicine('Paracetamol')">Paracetamol</li>
                        <li onclick="selectMedicine('Azithromycin')">Azithromycin</li>
                        <li onclick="selectMedicine('Prednisone')">Prednisone</li>
                        <li onclick="selectMedicine('Ciprofloxacin')">Ciprofloxacin</li>
                        <li onclick="selectMedicine('Levofloxacin')">Levofloxacin</li>
                        <li onclick="selectMedicine('Clindamycin')">Clindamycin</li>
                        <li onclick="selectMedicine('Naproxen')">Naproxen</li>
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
<!--    
        <script src="<?=ROOT?>/assets/js/script.js"></script> -->

        <script>
            let selectedMedicines = [];

            // Open Prescription Form
            function openPrescriptionForm(petName, petAge, cardId) {
            document.getElementById("prescriptionPopup").style.display = "flex";
            document.getElementById("prescriptionPopup").setAttribute("data-card-id", cardId); // Store the card ID
}

            // Filter Medicine List Based on Input
            function filterMedicines() {
                const searchValue = document.getElementById("medicineDropdown").value.toLowerCase();
                const medicineItems = document.querySelectorAll("#medicineList li");
                
                medicineItems.forEach((item) => {
                    item.style.display = item.innerText.toLowerCase().includes(searchValue) ? "block" : "none";
                });
            }

            // Add Medicine to Selected List
            function selectMedicine(medicine) {
                if (!selectedMedicines.includes(medicine)) {
                    selectedMedicines.push(medicine);
                    displaySelectedMedicines();
                }
            }

            // Display Selected Medicines
            function displaySelectedMedicines() {
                const medicineListDisplay = document.getElementById("medicineListDisplay");
                medicineListDisplay.innerHTML = "";
                
                selectedMedicines.forEach((medicine) => {
                    const li = document.createElement("li");
                    li.textContent = medicine;
                    medicineListDisplay.appendChild(li);
                });
            }

            // Close Popup and Clear Selected Medicines
            function closePopup() {
                document.getElementById("prescriptionPopup").style.display = "none";
                selectedMedicines = [];
                document.getElementById("medicineListDisplay").innerHTML = "";
                document.getElementById("medicineDropdown").value = "";
                document.getElementById("specialNote").value = "";
            }

            // Submit Prescription Data
            function submitPrescription() {
                const specialNote = document.getElementById("specialNote").value;
                const cardId = document.getElementById("prescriptionPopup").getAttribute("data-card-id");
                
                console.log("Selected Medicines:", selectedMedicines);
                console.log("Special Note:", specialNote);

                // Remove the prescription card
                if (cardId) {
                    const card = document.getElementById(cardId);
                    if (card) {
                        card.remove(); // Remove card from DOM
                    }
                }

                closePopup(); // Close form after submitting
                alert("Prescription submitted successfully!");
            }


            // Close Popup when clicking outside the form
            window.onclick = function(event) {
                if (event.target == document.getElementById("prescriptionPopup")) {
                    closePopup();
                }
            };
        </script>


    
   
</body>
</html>
