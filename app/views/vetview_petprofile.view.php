<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Profile</title>

    <link rel="icon" href="<?= ROOT ?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/vetview_petprofile.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/petownerappointments.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/sidebar.css">
</head>
<body>

    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar3.php'); ?>

        <main class="main-content">
            <div class="pet-profile-container">
                <?php if (!empty($petDetails)): 
                    $pet = $petDetails[0]; 
                ?>
                    <div class="pet-profile-card">
                        <div class="pet-image">
                            <img src="<?= ROOT ?>/assets/images/pets/default-pet.jpg" 
                                alt="<?= htmlspecialchars($pet->pet_name) ?> Image">
                        </div>

                        <div class="pet-details">
                            <h2><?= htmlspecialchars($pet->pet_name) ?></h2>
                            <ul>
                                <li><strong>Type:</strong> <?= htmlspecialchars($pet->pet_type) ?></li>
                                <li><strong>Breed:</strong> <?= htmlspecialchars($pet->breed) ?></li>
                                <li><strong>Age:</strong> <?= htmlspecialchars($pet->age) ?> Years</li>
                                <li><strong>Gender:</strong> <?= htmlspecialchars($pet->gender) ?></li>
                                <li><strong>Color:</strong> <?= htmlspecialchars($pet->color) ?></li>
                                <li><strong>Weight:</strong> <?= htmlspecialchars($pet->weight) ?> kg</li>
                                <li><strong>Vaccinations:</strong> <?= htmlspecialchars($pet->vaccinations) ?></li>
                                <li><strong>Date of Birth:</strong> <?= htmlspecialchars($pet->date_of_birth) ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="vet-actions">
                        <button type="button" class="btn" onclick="openPrescriptionModal()">Issue Prescription</button>

                        <form method="POST" action="<?= ROOT ?>/vetmedicalrecord/update">
                            <input type="hidden" name="pet_id" value="<?= htmlspecialchars($pet->pet_id) ?>">
                            <button type="submit" class="btn secondary">Update Medical Record</button>
                        </form>
                    </div>

                <?php else: ?>
                    <p>No pet data found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Prescription Modal -->
    <div id="prescriptionModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">
            <button class="close" onclick="closePrescriptionModal()" aria-label="Close">&times;</button>
            <h3 id="modalTitle">Fill Prescription</h3>

            <?php if (!empty($petDetails)): ?>
            <form method="POST" action="<?= ROOT ?>/vetview_petprofile/issueprescription" onsubmit="return preparePrescriptionData()">
                <input type="hidden" name="pet_id" value="<?= htmlspecialchars($pet->pet_id) ?>">

                <div class="medicine-select">
                    <label for="medicineDropdown">Select Medicines:</label>
                    <input type="text" id="medicineDropdown" oninput="filterMedicines()" placeholder="Search for medicine..." onclick="showMedicineList()">
                    
                    <ul id="medicineList" class="dropdown-list" style="display:none;">
                        <?php if(!empty($medicineDetails)): ?>
                            <?php foreach($medicineDetails as $medicine): ?>
                                <li onclick="selectMedicine('<?= htmlspecialchars($medicine->med_id) ?>', '<?= htmlspecialchars($medicine->med_name) ?>')">
                                    <?= htmlspecialchars($medicine->med_name) ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No medicines available</li>
                        <?php endif; ?>
                    </ul>

                </div>
                <br/>

                <div id="selectedMedicines">
                    <h4>Selected Medicines:</h4>
                    <ul id="medicineListDisplay"></ul>
                </div>
                <br/>
                <label for="specialNote">Special Note (if any):</label>
                <textarea id="specialNote" name="special_note" rows="3"></textarea>
                <br/>
                <input type="hidden" name="prescribed_medicines" id="prescribed_medicines">
                <br/>
                <button type="submit" class="btn">Submit Prescription</button>
            </form>
            <?php endif; ?>
        </div>
    </div>

<script>
    let selectedMedicines = [];

    function openPrescriptionModal() {
        document.getElementById("prescriptionModal").style.display = "block";
    }

    function closePrescriptionModal() {
        document.getElementById("prescriptionModal").style.display = "none";
    }

    function showMedicineList() {
        document.getElementById("medicineList").style.display = "block";
    }

    function filterMedicines() {
        const search = document.getElementById("medicineDropdown").value.toLowerCase();
        const list = document.getElementById("medicineList");
        let hasVisible = false;

        document.querySelectorAll("#medicineList li").forEach(item => {
            if (item.textContent.toLowerCase().includes(search)) {
                item.style.display = "block";
                hasVisible = true;
            } else {
                item.style.display = "none";
            }
        });

        list.style.display = hasVisible ? "block" : "none";
    }

    function selectMedicine(medId, medicineName) {
        if (!selectedMedicines.some(med => med.id === medId)) {
            selectedMedicines.push({ id: medId, name: medicineName, dosage: "", frequency: "" });
            updateSelectedMedicinesUI();
        }
        document.getElementById("medicineList").style.display = "none";
        document.getElementById("medicineDropdown").value = "";
    }

    function updateSelectedMedicinesUI() {
        const container = document.getElementById("medicineListDisplay");
        container.innerHTML = "";

        selectedMedicines.forEach((med, index) => {
            const li = document.createElement("li");
            li.innerHTML = `
                <span>${med.name}</span>
                <input type="text" placeholder="Dosage (e.g., 250mg)" 
                    class="dosage-input" data-index="${index}" oninput="updateDosage(this)">
                <input type="text" placeholder="Frequency (e.g., Twice a day)" 
                    class="frequency-input" data-index="${index}" oninput="updateFrequency(this)">
            `;
            container.appendChild(li);
        });
    }

    function updateDosage(input) {
        const index = input.dataset.index;
        selectedMedicines[index].dosage = input.value;
    }

    function updateFrequency(input) {
        const index = input.dataset.index;
        selectedMedicines[index].frequency = input.value;
    }

    function preparePrescriptionData() {
        document.getElementById('prescribed_medicines').value = JSON.stringify(selectedMedicines);
        return true;
    }
</script>

<?php include('components/footer.php'); ?>
<script src="<?= ROOT ?>/assets/js/script.js"></script>

</body>
</html>







