<?php
$grouped = [];

if (!empty($prescriptionDetails)) {
    foreach ($prescriptionDetails as $item) {
        $id = $item->prescription_id;

        if (!isset($grouped[$id])) {
            $grouped[$id] = [
                'prescription_id' => $id,
                'pet_id' => $item->pet_id,
                'vet_id' => $item->vet_id,
                'special_note' => $item->special_note,
                'created_at' => $item->created_at,
                'time_stamp' => $item->time_stamp,
                'medicines' => []
            ];
        }

        $grouped[$id]['medicines'][] = [
            'med_id' => $item->med_id,
            'dosage' => $item->dosage,
            'frequency' => $item->frequency,
            'med_name' => $item->med_name,
            'med_description' => $item->med_description
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Profile</title>

    <link rel="icon" href="<?= ROOT ?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                            <img src="<?= ROOT ?>/assets/images/dog1.avif" 
                                alt="<?= htmlspecialchars($pet->pet_name) ?> Image">
                        </div>

                        <div class="pet-details">
                            <h2><i class="fas fa-paw"></i> <?= htmlspecialchars($pet->pet_name) ?></h2>
                            <ul>
                                <li><i class="fas fa-dog"></i> <strong>Type:</strong> <?= htmlspecialchars($pet->pet_type) ?></li>
                                <li><i class="fas fa-dna"></i> <strong>Breed:</strong> <?= htmlspecialchars($pet->breed) ?></li>
                                <li><i class="fas fa-hourglass-half"></i> <strong>Age:</strong> <?= htmlspecialchars($pet->age) ?> Years</li>
                                <li><i class="fas fa-venus-mars"></i> <strong>Gender:</strong> <?= htmlspecialchars($pet->gender) ?></li>
                                <li><i class="fas fa-palette"></i> <strong>Color:</strong> <?= htmlspecialchars($pet->color) ?></li>
                                <li><i class="fas fa-weight"></i> <strong>Weight:</strong> <?= htmlspecialchars($pet->weight) ?> kg</li>
                                <li><i class="fas fa-syringe"></i> <strong>Vaccinations:</strong> <?= htmlspecialchars($pet->vaccinations) ?></li>
                                <li><i class="fas fa-calendar-alt"></i> <strong>Date of Birth:</strong> <?= htmlspecialchars($pet->date_of_birth) ?></li>
                            </ul>
                        </div>

                    </div>

                    <div class="vet-actions">
                        <button type="button" class="btn" onclick="openViewPrescriptionModal()">View Prescriptions</button>

                        <button type="button" class="btn" onclick="openPrescriptionModal()">Issue Prescription</button>

                        <button type="button" class="btn" onclick="openMedicalHistoryModal()">View Medical History</button>

                        <button type="button" class="btn" onclick="openMedicalRecordModal()">Update Medical Record</button>
                   
                        
                    </div>

                <?php else: ?>
                    <p>No pet data found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- View Prescription Modal -->

    <div id="viewPrescriptionModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">
            <button class="close" onclick="closeViewPrescriptionModal()" aria-label="Close">&times;</button>
            <h3 id="modalTitle">Issued Prescriptions</h3>
            
                <?php if(!empty($grouped)): ?>
                    <?php foreach($grouped as $prescription): ?>
                        <div class="prescription-group">
                            <p><strong>Prescription ID:</strong> <?= htmlspecialchars($prescription['prescription_id']) ?></p>   
                            
                            <p><strong>Date:</strong> <?= htmlspecialchars($prescription['created_at']) ?></p>

                            <?php if (!empty($prescription['medicines'])): ?>
                                <ul>
                                    <?php foreach ($prescription['medicines'] as $med): ?>
                                        <li>
                                            <strong><?= htmlspecialchars($med['med_name']) ?></strong> – 
                                            <?= htmlspecialchars($med['dosage']) ?>, 
                                            <?= htmlspecialchars($med['frequency']) ?>
                                            <br>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <p><strong>Special Note:</strong> <?= htmlspecialchars($prescription['special_note']) ?></p>
                            <?php else: ?>
                                <p>No medicines listed.</p>
                            <?php endif; ?>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No prescriptions available.</p>
                <?php endif; ?>

            </div>                    
        </div>
    </div>

    <!-- Issue Prescription Modal -->
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

    <!-- View Medical History Modal -->

    <div id="medicalHistoryModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">
            <button class="close" onclick="closeMedicalHistoryModal()" aria-label="Close">&times;</button>
            <table border="1">
                <tr>
                    <th>Date</th>
                    <th>Vaccinations Given</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>

                <?php if (!empty($medicalHistoryDetails) && is_array($medicalHistoryDetails)): ?>
                    <?php foreach($medicalHistoryDetails as $medhist): ?>
                        <tr>
                            <td><?= htmlspecialchars($medhist->date) ?></td>
                            <td><?= htmlspecialchars($medhist->vaccination_given) ?></td>
                            <td><?= htmlspecialchars($medhist->special_note) ?></td>
                            <td>
                                <?php if (isset($_SESSION['vet_id']) && $_SESSION['vet_id'] == $medhist->vet_id): ?>
                                    <button type="button" class="btn" onclick="openMedicalRecordUpdateModal('<?= htmlspecialchars($medhist->record_id) ?>','<?= htmlspecialchars($medhist->vaccination_given) ?>','<?= htmlspecialchars($medhist->special_note) ?>')">Update</button>

                                    <form action="<?= ROOT ?>/vetview_petprofile/deletemedicalrecord" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        <input type="hidden" name="record_id" value="<?= htmlspecialchars($medhist->record_id) ?>">
                                        <button type="submit">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No medical records...</td>
                    </tr>
                <?php endif; ?>

            </table>
        </div>
    </div>


    <!--Insert  Medical Record Modal -->
    <div id="medicalRecordModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">
            <button class="close" onclick="closeMedicalRecordModal()" aria-label="Close">&times;</button>
            <h3 id="modalTitle">Update Medical Record</h3>

            <?php if (!empty($petDetails)): ?>
            <form method="POST" action="<?= ROOT ?>/vetview_petprofile/insertmedicalrecord" >
                <input type="hidden" name="pet_id" value="<?= htmlspecialchars($pet->pet_id) ?>">
                Vaccinations given:
                <input type="text" name="vaccination_given" required>
                <br/><br/>
                <label for="specialNote">Special Note (if any):</label>
                <textarea id="medical_specialNote" name="special_note" rows="3"required></textarea>
                <br/>
                <br/>
                <button type="submit" class="btn">Update</button>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Medical Record Update Modal -->
    <div id="medicalRecordUpdateModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">
            <button class="close" onclick="closeMedicalRecordUpdateModal()" aria-label="Close">&times;</button>
            <h3 id="modalTitle">Update Medical Record</h3>

            <?php if (!empty($petDetails)): ?>
            <form method="POST" action="<?= ROOT ?>/vetview_petprofile/updatemedicalrecord" >
                <input type="hidden" name="pet_id" value="<?= htmlspecialchars($pet->pet_id) ?>">
                <input type="hidden" id="record_id" name="record_id" ?>
                Vaccinations given:
                <input type="text" name="vaccination_given" required>
                <br/><br/>
                <label for="specialNote">Special Note (if any):</label>
                <textarea id="medical_specialNote" name="special_note" rows="3"required></textarea>
                <br/>
                <br/>
                <button type="submit" class="btn">Update</button>
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

    function openViewPrescriptionModal(){
        document.getElementById("viewPrescriptionModal").style.display = "block";
    }

    function closeViewPrescriptionModal(){
        document.getElementById("viewPrescriptionModal").style.display = "none";
    }
    

    function openMedicalHistoryModal() {
        document.getElementById("medicalHistoryModal").style.display = "block";
    }

    function closeMedicalHistoryModal() {
        document.getElementById("medicalHistoryModal").style.display = "none";
    }

    function openMedicalRecordModal() {
        document.getElementById("medicalRecordModal").style.display = "block";
    }

    function closeMedicalRecordModal() {
        document.getElementById("medicalRecordModal").style.display = "none";
    }

    function openMedicalRecordUpdateModal(recordId, vaccination, note) {
        document.getElementById("medicalRecordUpdateModal").style.display = "block";
        
        document.querySelector("#medicalRecordUpdateModal input[name='record_id']").value = recordId;
        document.querySelector("#medicalRecordUpdateModal input[name='vaccination_given']").value = vaccination;
        document.querySelector("#medicalRecordUpdateModal textarea[name='special_note']").value = note;
    }

    function closeMedicalRecordUpdateModal() {
        document.getElementById("medicalRecordUpdateModal").style.display = "none";
    }
</script>

<!-- <?php include('components/footer.php'); ?> -->
<script src="<?= ROOT ?>/assets/js/script.js"></script>

</body>
</html>







