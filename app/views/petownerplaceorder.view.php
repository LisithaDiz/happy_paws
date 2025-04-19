<?php
// Remove the hardcoded $pets array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/placeorder.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">

    <title>Place Order to <?= htmlspecialchars($selectedPharmacy->name) ?></title>
   
    <style>
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            position: relative;
        }

        .popup-message {
            margin-bottom: 20px;
            font-size: 18px;
            color: #155724;
        }

        .popup-close {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d8544c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .popup-close:hover {
            background-color: #c14841;
        }

        .medicine-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }

        .medicine-row select,
        .medicine-row input {
            flex: 1;
        }

        .remove-medicine {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .remove-medicine:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <?php include('components/nav2.php'); ?>

    <!-- Main Content -->
    <div class="dashboard-container">
        <?php include('components/sidebar.php'); ?>
        <h1 class="dashboard-heading">Place an Order to <?= htmlspecialchars($selectedPharmacy->name) ?></h1>

        <!-- Place Order Form -->
        <div class="place-order-container">
            <?php if(isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form id="orderForm" method="POST" action="<?=ROOT?>/PlaceOrder/create/<?= htmlspecialchars($selectedPharmacy->pharmacy_id) ?>">
                <!-- Add debug info -->
                <?php
                error_log("Form action URL: " . ROOT . "/PlaceOrder/create/" . $selectedPharmacy->pharmacy_id);
                ?>
                <input type="hidden" name="pharmacy_id" value="<?= htmlspecialchars($selectedPharmacy->pharmacy_id) ?>">
                
                <div class="form-group">
                    <label for="pet_id">Select Pet</label>
                    <select id="pet_id" name="pet_id" required onchange="loadPrescriptions(this.value)">
                        <option value="">Select a pet</option>
                        <?php if(!empty($pets)): ?>
                            <?php foreach ($pets as $pet): ?>
                                <option value="<?= $pet->pet_id ?>"><?= htmlspecialchars($pet->pet_name) ?> (<?= htmlspecialchars($pet->pet_type) ?>)</option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No pets found</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group" id="prescription-section" style="display: none;">
                    <label for="prescription_id">Select Prescription (Optional)</label>
                    <select id="prescription_id" name="prescription_id" onchange="viewPrescriptionDetails(this.value)">
                        <option value="">No prescription</option>
                    </select>
                    <div id="prescription-details" style="display: none; margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 5px;">
                        <h4>Prescription Details</h4>
                        <div id="prescription-info"></div>
                    </div>
                </div>

                <!-- Medicines & Quantities -->
                <div class="form-group">
                    <label>Medicines</label>
                    <div id="medicine-rows">
                        <div class="medicine-row">
                            <select name="medicines[0][med_id]" required onchange="updateTotalPrice()">
                                <option value="">Select medicine</option>
                                <?php if(!empty($medicines)): ?>
                                    <?php foreach ($medicines as $medicine): ?>
                                        <option value="<?= $medicine->med_id ?>" data-price="<?= $medicine->price ?>">
                                            <?= htmlspecialchars($medicine->med_name) ?> - Rs.<?= number_format($medicine->price, 2) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <input type="number" name="medicines[0][quantity]" min="1" value="1" required onchange="updateTotalPrice()">
                            <button type="button" class="remove-medicine" onclick="removeMedicineRow(this)">Remove</button>
                        </div>
                    </div>
                    <button type="button" onclick="addMedicineRow()">Add Medicine</button>
                </div>

                <div class="form-group">
                    <label>Total Price:</label>
                    <input type="text" id="total_price" name="total_price" value="0.00" readonly>
                </div>

                <div class="form-group" style="text-align: center;">
                    <button type="submit" class="submit-order-btn">Submit Order</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include('components/footer.php'); ?>

    <div class="popup-overlay" id="successPopup">
        <div class="popup-content">
            <div class="popup-message" id="popupMessage"></div>
            <button class="popup-close" onclick="closePopup()">Close</button>
        </div>
    </div>

    <script>
        function addMedicineRow() {
            const container = document.getElementById('medicine-rows');
            const rowCount = container.children.length;
            const newRow = document.createElement('div');
            newRow.className = 'medicine-row';
            newRow.innerHTML = `
                <select name="medicines[${rowCount}][med_id]" required onchange="updateTotalPrice()">
                    <option value="">Select medicine</option>
                    <?php if(!empty($medicines)): ?>
                        <?php foreach ($medicines as $medicine): ?>
                            <option value="<?= $medicine->med_id ?>" data-price="<?= $medicine->price ?>">
                                <?= htmlspecialchars($medicine->med_name) ?> - Rs.<?= number_format($medicine->price, 2) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <input type="number" name="medicines[${rowCount}][quantity]" min="1" value="1" required onchange="updateTotalPrice()">
                <button type="button" class="remove-medicine" onclick="removeMedicineRow(this)">Remove</button>
            `;
            container.appendChild(newRow);
            updateTotalPrice();
        }

        function removeMedicineRow(button) {
            if (document.querySelectorAll('.medicine-row').length > 1) {
                const row = button.parentElement;
                row.remove();
                updateTotalPrice();
            } else {
                alert('You must have at least one medicine in the order.');
            }
        }

        function updateTotalPrice() {
            let total = 0;
            const rows = document.querySelectorAll('.medicine-row');
            
            rows.forEach(row => {
                const select = row.querySelector('select');
                const quantityInput = row.querySelector('input[type="number"]');
                const selectedOption = select.options[select.selectedIndex];
                
                if (selectedOption && selectedOption.dataset.price) {
                    const price = parseFloat(selectedOption.dataset.price);
                    const quantity = parseInt(quantityInput.value) || 0;
                    total += price * quantity;
                }
            });
            
            document.getElementById('total_price').value = total.toFixed(2);
        }

        // Initialize total price calculation
        document.addEventListener('DOMContentLoaded', function() {
            updateTotalPrice();
        });

        function showPopup(message) {
            document.getElementById('popupMessage').textContent = message;
            document.getElementById('successPopup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('successPopup').style.display = 'none';
            // Reset the form after closing the popup
            document.getElementById('orderForm').reset();
            // Reset the medicine container to have only one row
            document.getElementById('medicine-rows').innerHTML = `
                <div class="medicine-row">
                    <select name="medicines[0][med_id]" required onchange="updateTotalPrice()">
                        <option value="">Select medicine</option>
                        <?php if(!empty($medicines)): ?>
                            <?php foreach ($medicines as $medicine): ?>
                                <option value="<?= $medicine->med_id ?>" data-price="<?= $medicine->price ?>">
                                    <?= htmlspecialchars($medicine->med_name) ?> - Rs.<?= number_format($medicine->price, 2) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <input type="number" name="medicines[0][quantity]" min="1" value="1" required onchange="updateTotalPrice()">
                    <button type="button" class="remove-medicine" onclick="removeMedicineRow(this)">Remove</button>
                </div>
            `;
            updateTotalPrice();
        }

        function loadPrescriptions(petId) {
            if (!petId) {
                document.getElementById('prescription-section').style.display = 'none';
                document.getElementById('prescription-details').style.display = 'none';
                return;
            }

            document.getElementById('prescription-section').style.display = 'block';
            const prescriptionSelect = document.getElementById('prescription_id');
            prescriptionSelect.innerHTML = '<option value="">Loading prescriptions...</option>';

            // Make AJAX request to fetch prescriptions
            const xhr = new XMLHttpRequest();
            const url = `<?= ROOT ?>/PlaceOrder/getPrescriptions/${petId}`;
            console.log('Fetching prescriptions from:', url);
            
            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                console.log('Response status:', xhr.status);
                console.log('Response text:', xhr.responseText);
                
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Parsed response:', response);
                        
                        if (response.error) {
                            console.error('Server error:', response.error);
                            prescriptionSelect.innerHTML = `<option value="">${response.error}</option>`;
                            return;
                        }
                        
                        prescriptionSelect.innerHTML = '<option value="">No prescription</option>';
                        
                        if (response.prescriptions && response.prescriptions.length > 0) {
                            response.prescriptions.forEach(prescription => {
                                const option = document.createElement('option');
                                option.value = prescription.prescription_id;
                                const date = new Date(prescription.created_at);
                                const formattedDate = date.toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric'
                                });
                                option.textContent = `Prescription #${prescription.prescription_id} - ${formattedDate}`;
                                prescriptionSelect.appendChild(option);
                            });
                        } else {
                            prescriptionSelect.innerHTML = '<option value="">No prescriptions found</option>';
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        console.error('Raw response:', xhr.responseText);
                        prescriptionSelect.innerHTML = '<option value="">Error loading prescriptions</option>';
                    }
                } else {
                    console.error('Error loading prescriptions:', xhr.status);
                    console.error('Response text:', xhr.responseText);
                    prescriptionSelect.innerHTML = '<option value="">Error loading prescriptions</option>';
                }
            };
            
            xhr.onerror = function(e) {
                console.error('Network error while loading prescriptions:', e);
                prescriptionSelect.innerHTML = '<option value="">Error loading prescriptions</option>';
            };
            
            xhr.send();
        }

        function viewPrescriptionDetails(prescriptionId) {
            const detailsDiv = document.getElementById('prescription-details');
            const infoDiv = document.getElementById('prescription-info');
            
            if (!prescriptionId) {
                detailsDiv.style.display = 'none';
                return;
            }

            detailsDiv.style.display = 'block';
            infoDiv.innerHTML = 'Loading prescription details...';

            // Make AJAX request to fetch prescription details
            const xhr = new XMLHttpRequest();
            const url = `<?= ROOT ?>/Prescription/view/${prescriptionId}`;
            console.log('Fetching prescription details from:', url);
            
            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                console.log('Response status:', xhr.status);
                console.log('Response text:', xhr.responseText);
                
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Parsed response:', response);
                        
                        if (response.error) {
                            infoDiv.innerHTML = `<div class="error">${response.error}</div>`;
                            return;
                        }

                        if (response.prescription) {
                            let html = `
                                <div class="prescription-info">
                                    <div class="info-item">
                                        <label>Date:</label>
                                        <span>${new Date(response.prescription.created_at).toLocaleDateString()}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Vet:</label>
                                        <span>${response.prescription.vet_name}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Pet:</label>
                                        <span>${response.prescription.pet_name}</span>
                                    </div>
                                </div>
                            `;
                            
                            if (response.prescription.special_note) {
                                html += `
                                    <div class="special-notes">
                                        <label>Special Notes:</label>
                                        <p>${response.prescription.special_note}</p>
                                    </div>
                                `;
                            }
                            
                            html += `
                                <div class="medicines-list">
                                    <h4>Prescribed Medicines:</h4>
                            `;
                            
                            if (response.medicines && response.medicines.length > 0) {
                                response.medicines.forEach(medicine => {
                                    html += `
                                        <div class="medicine-item">
                                            <div class="medicine-header">
                                                <span class="medicine-name">${medicine.med_name}</span>
                                            </div>
                                        </div>
                                    `;
                                });
                            } else {
                                html += '<p>No medicines prescribed</p>';
                            }
                            
                            html += '</div>';
                            infoDiv.innerHTML = html;
                        } else {
                            infoDiv.innerHTML = 'Prescription details not found';
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        console.error('Raw response:', xhr.responseText);
                        infoDiv.innerHTML = '<div class="error">Error loading prescription details</div>';
                    }
                } else {
                    console.error('Error loading prescription details:', xhr.status);
                    console.error('Response text:', xhr.responseText);
                    infoDiv.innerHTML = '<div class="error">Error loading prescription details</div>';
                }
            };
            
            xhr.onerror = function(e) {
                console.error('Network error while loading prescription details:', e);
                infoDiv.innerHTML = '<div class="error">Error loading prescription details</div>';
            };
            
            xhr.send();
        }

        document.getElementById('orderForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            
            // Validate medicines and quantities
            const medicineRows = document.querySelectorAll('.medicine-row');
            let isValid = true;
            let errorMessage = '';
            let hasValidMedicine = false;

            // Debug logging
            console.log('Validating medicine rows:', medicineRows.length);

            medicineRows.forEach((row, index) => {
                const medicineSelect = row.querySelector('select[name^="medicines"][name$="[med_id]"]');
                const quantityInput = row.querySelector('input[name^="medicines"][name$="[quantity]"]');

                console.log(`Row ${index + 1}:`, {
                    medicineValue: medicineSelect.value,
                    quantityValue: quantityInput.value,
                    medicineText: medicineSelect.options[medicineSelect.selectedIndex]?.text
                });

                // Check if this row has a valid medicine selection
                if (medicineSelect.value && medicineSelect.value !== '' && 
                    quantityInput.value && parseInt(quantityInput.value) > 0) {
                    hasValidMedicine = true;
                }
            });

            if (!hasValidMedicine) {
                isValid = false;
                errorMessage = 'Please select at least one medicine with a valid quantity';
            }

            if (!isValid) {
                console.log('Validation failed:', errorMessage);
                alert(errorMessage);
                return;
            }

            try {
                // Get form data
                const formData = new FormData(this);
                
                // Debug logging
                console.log('Form submission started');
                console.log('Form action:', this.action);
                console.log('Form method:', this.method);
                
                // Log all form data
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }
                
                // Submit form using fetch
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Response:', data);

                if (data.success) {
                    showPopup(data.message);
                } else {
                    alert(data.message || 'An error occurred while placing the order.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while placing the order. Please try again.');
            }
        });
    </script>
</body>
</html>
