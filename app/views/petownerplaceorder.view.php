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
        /* General Styles */
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-heading {
            color: #d8544c;
            font-size: 2em;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .dashboard-heading:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background-color: #f8929c;
        }

        /* Form Container */
        .place-order-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #d8544c;
            font-weight: 500;
            font-size: 1.1em;
        }

        /* Input Fields */
        select, input[type="number"], input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        select:focus, input[type="number"]:focus, input[type="text"]:focus {
            border-color: #d8544c;
            box-shadow: 0 0 0 3px rgba(216, 84, 76, 0.1);
            outline: none;
            background-color: white;
        }

        /* Medicine Rows */
        .medicine-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .medicine-name {
            flex: 1;
            font-weight: 500;
        }

        .medicine-quantity {
            min-width: 50px;
            text-align: center;
        }

        .remove-medicine {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .remove-medicine:hover {
            background-color: #c82333;
        }

        /* Add Medicine Button */
        .add-medicine-btn {
            background-color: #f8929c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-medicine-btn:hover {
            background-color: #d8544c;
            transform: translateY(-1px);
        }

        /* Total Price */
        .total-price-container {
            background-color: #fff5f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .total-price-label {
            font-size: 1.2em;
            color: #d8544c;
            margin-bottom: 10px;
        }

        .total-price-value {
            font-size: 1.8em;
            color: #d8544c;
            font-weight: bold;
        }

        /* Submit Button */
        .submit-order-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            transition: all 0.3s ease;
            display: block;
            margin: 0 auto;
            width: fit-content;
        }

        .submit-order-btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
        }

        /* Prescription Section */
        .prescription-section {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            margin-top: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .prescription-section:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        }

        .prescription-details {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #e0e0e0;
        }

        .prescription-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .prescription-title {
            color: #d8544c;
            font-size: 1.4em;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .prescription-title i {
            color: #f8929c;
        }

        .prescription-date {
            color: #666;
            font-size: 0.9em;
            background-color: #f8f9fa;
            padding: 8px 15px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .prescription-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .prescription-info-item {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .prescription-info-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .prescription-info-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: #d8544c;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .prescription-info-item:hover::before {
            opacity: 1;
        }

        .prescription-info-item label {
            display: block;
            color: #666;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .prescription-info-item span {
            color: #333;
            font-size: 1.1em;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .prescription-medicines {
            margin-top: 25px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .prescription-medicines h4 {
            color: #d8544c;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 1.2em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .medicine-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .medicine-list li {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .medicine-list li:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .medicine-info {
            flex: 1;
        }

        .medicine-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            font-size: 1.1em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .medicine-details {
            color: #666;
            font-size: 0.9em;
        }

        .medicine-details div {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .medicine-details i {
            color: #d8544c;
            font-size: 0.9em;
        }

        .special-notes {
            background-color: #fff5f6;
            padding: 25px;
            border-radius: 8px;
            margin-top: 25px;
            position: relative;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .special-notes::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: #d8544c;
        }

        .special-notes strong {
            color: #d8544c;
            display: block;
            margin-bottom: 15px;
            font-size: 1.1em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .special-notes p {
            color: #333;
            line-height: 1.6;
            margin: 0;
            font-size: 1em;
        }

        /* Loading State */
        .loading-state {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #f0f0f0;
            border-top: 3px solid #d8544c;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Error State */
        .error-state {
            background-color: #fff;
            color: #d8544c;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .error-state i {
            font-size: 2em;
            margin-bottom: 15px;
            color: #d8544c;
        }

        /* Error Message */
        .error-message {
            background-color: #fff5f6;
            color: #d8544c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        /* Success Popup */
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
            animation: fadeIn 0.3s ease;
        }

        .popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            position: relative;
            animation: slideIn 0.3s ease;
        }

        .popup-message {
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #28a745;
            font-weight: 500;
        }

        .popup-close {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .popup-close:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .medicine-row {
                flex-direction: column;
                gap: 10px;
            }

            .medicine-row select,
            .medicine-row input {
                width: 100%;
            }

            .remove-medicine {
                width: 100%;
                justify-content: center;
            }

            .dashboard-heading {
                font-size: 1.5em;
            }

            .prescription-info {
                grid-template-columns: 1fr;
            }

            .prescription-info-item {
                margin-bottom: 15px;
            }

            .medicine-list li {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .prescription-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }

        /* Responsive Design for Prescription Section */
        @media (max-width: 768px) {
            .prescription-info {
                grid-template-columns: 1fr;
            }

            .prescription-info-item {
                margin-bottom: 15px;
            }

            .prescription-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
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
                    <div class="prescription-details" style="display: none; margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 5px;">
                        <h4>Prescription Details</h4>
                        <div class="prescription-info">
                            <div class="info-item">
                                <label>Date:</label>
                                <span id="prescription-date"></span>
                            </div>
                            <div class="info-item">
                                <label>Vet:</label>
                                <span id="prescription-vet"></span>
                            </div>
                            <div class="info-item">
                                <label>Pet:</label>
                                <span id="prescription-pet"></span>
                            </div>
                        </div>
                        
                        <div class="medicines-list">
                            <h4>Prescribed Medicines:</h4>
                            <div id="prescription-medicines"></div>
                        </div>
                        
                        <div class="special-notes" id="prescription-notes" style="display: none;">
                            <strong>Special Notes:</strong>
                            <p id="prescription-note-text"></p>
                        </div>
                    </div>
                </div>

                <!-- Medicines & Quantities -->
                <div class="form-group">
                    <label>Medicines</label>
                    <div id="medicine-rows">
                        <div class="medicine-row">
                            <input type="hidden" name="medicines[0][med_id]" value="">
                            <span class="medicine-name"></span>
                            <input type="hidden" name="medicines[0][quantity]" value="1">
                            <span class="medicine-quantity"></span>
                            <button type="button" class="remove-medicine" onclick="removeMedicineRow(this)">Remove</button>
                        </div>
                    </div>
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
            const row = button.parentElement;
            const container = document.getElementById('medicine-rows');
            const rows = container.querySelectorAll('.medicine-row');
            
            // Only allow removal if there's more than one row
            if (rows.length > 1) {
                row.remove();
                updateTotalPrice();
            } else {
                alert('You must keep at least one medicine in the order.');
            }
        }

        function updateTotalPrice() {
            let total = 0;
            const rows = document.querySelectorAll('.medicine-row');
            
            rows.forEach(row => {
                const medIdInput = row.querySelector('input[name^="medicines"][name$="[med_id]"]');
                const quantityInput = row.querySelector('input[name^="medicines"][name$="[quantity]"]');
                
                if (medIdInput && quantityInput) {
                    // Get the medicine name from the span
                    const medicineName = row.querySelector('.medicine-name').textContent;
                    // Find the medicine in the original medicines array
                    const medicine = <?= json_encode($medicines) ?>.find(m => m.med_name === medicineName);
                    
                    if (medicine) {
                        const price = parseFloat(medicine.price);
                        const quantity = parseInt(quantityInput.value) || 0;
                        total += price * quantity;
                    }
                }
            });
            
            document.getElementById('total_price').value = total.toFixed(2);
        }

        // Initialize total price calculation
        document.addEventListener('DOMContentLoaded', function() {
            updateTotalPrice();
        });

        function showPopup(message) {
            const popupMessage = document.getElementById('popupMessage');
            const popupOverlay = document.getElementById('successPopup');
            
            popupMessage.textContent = message;
            popupOverlay.style.display = 'flex';
            
            // Auto-close after 5 seconds
            setTimeout(() => {
                closePopup();
            }, 5000);
        }

        function closePopup() {
            const popupOverlay = document.getElementById('successPopup');
            popupOverlay.style.display = 'none';
            
            // Reset the form after closing the popup
            document.getElementById('orderForm').reset();
            
            // Reset the medicine container to have only one row
            const container = document.getElementById('medicine-rows');
            container.innerHTML = `
                <div class="medicine-row">
                    <input type="hidden" name="medicines[0][med_id]" value="">
                    <span class="medicine-name"></span>
                    <input type="hidden" name="medicines[0][quantity]" value="1">
                    <span class="medicine-quantity"></span>
                    <button type="button" class="remove-medicine" onclick="removeMedicineRow(this)">Remove</button>
                </div>
            `;
            updateTotalPrice();
        }

        function loadPrescriptions(petId) {
            if (!petId) {
                document.getElementById('prescription-section').style.display = 'none';
                document.querySelector('.prescription-details').style.display = 'none';
                return;
            }

            document.getElementById('prescription-section').style.display = 'block';
            const prescriptionSelect = document.getElementById('prescription_id');
            prescriptionSelect.innerHTML = '<option value="">Loading prescriptions...</option>';

            // Make AJAX request to fetch prescriptions
            const xhr = new XMLHttpRequest();
            const url = `<?= ROOT ?>/PlaceOrder/getPrescriptions/${petId}`;
            
            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.error) {
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
                        prescriptionSelect.innerHTML = '<option value="">Error loading prescriptions</option>';
                    }
                } else {
                    console.error('Error loading prescriptions:', xhr.status);
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
            const detailsDiv = document.querySelector('.prescription-details');
            const medicinesDiv = document.getElementById('prescription-medicines');
            const notesDiv = document.getElementById('prescription-notes');
            
            if (!prescriptionId) {
                detailsDiv.style.display = 'none';
                // Clear medicine rows if no prescription selected
                const medicineRows = document.querySelectorAll('.medicine-row');
                medicineRows.forEach((row, index) => {
                    if (index > 0) { // Keep first row
                        row.remove();
                    } else {
                        // Reset first row
                        const nameSpan = row.querySelector('.medicine-name');
                        const quantitySpan = row.querySelector('.medicine-quantity');
                        const medIdInput = row.querySelector('input[name^="medicines"][name$="[med_id]"]');
                        const quantityInput = row.querySelector('input[name^="medicines"][name$="[quantity]"]');
                        nameSpan.textContent = '';
                        quantitySpan.textContent = '';
                        medIdInput.value = '';
                        quantityInput.value = '1';
                    }
                });
                updateTotalPrice();
                return;
            }

            detailsDiv.style.display = 'block';
            medicinesDiv.innerHTML = 'Loading prescription details...';

            // Make AJAX request to fetch prescription details
            const xhr = new XMLHttpRequest();
            const url = `<?= ROOT ?>/Prescription/view/${prescriptionId}`;
            
            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.error) {
                            medicinesDiv.innerHTML = `<div class="error">${response.error}</div>`;
                            return;
                        }

                        if (response.prescription) {
                            // Update prescription info
                            document.getElementById('prescription-date').textContent = new Date(response.prescription.created_at).toLocaleDateString();
                            document.getElementById('prescription-vet').textContent = response.prescription.vet_name;
                            document.getElementById('prescription-pet').textContent = response.prescription.pet_name;

                            // Update medicines list
                            let medicinesHtml = '';
                            if (response.medicines && response.medicines.length > 0) {
                                // Clear existing medicine rows except the first one
                                const medicineRows = document.querySelectorAll('.medicine-row');
                                medicineRows.forEach((row, index) => {
                                    if (index > 0) {
                                        row.remove();
                                    }
                                });

                                // Add medicine rows for each prescribed medicine
                                const container = document.getElementById('medicine-rows');
                                response.medicines.forEach((medicine, index) => {
                                    if (index === 0) {
                                        // Update first row
                                        const firstRow = container.querySelector('.medicine-row');
                                        const nameSpan = firstRow.querySelector('.medicine-name');
                                        const quantitySpan = firstRow.querySelector('.medicine-quantity');
                                        const medIdInput = firstRow.querySelector('input[name^="medicines"][name$="[med_id]"]');
                                        const quantityInput = firstRow.querySelector('input[name^="medicines"][name$="[quantity]"]');
                                        
                                        nameSpan.textContent = medicine.med_name;
                                        quantitySpan.textContent = medicine.quantity;
                                        medIdInput.value = medicine.med_id;
                                        quantityInput.value = medicine.quantity;
                                    } else {
                                        // Add new row for additional medicines
                                        const newRow = document.createElement('div');
                                        newRow.className = 'medicine-row';
                                        newRow.innerHTML = `
                                            <input type="hidden" name="medicines[${index}][med_id]" value="${medicine.med_id}">
                                            <span class="medicine-name">${medicine.med_name}</span>
                                            <input type="hidden" name="medicines[${index}][quantity]" value="${medicine.quantity}">
                                            <span class="medicine-quantity">${medicine.quantity}</span>
                                            <button type="button" class="remove-medicine" onclick="removeMedicineRow(this)">Remove</button>
                                        `;
                                        container.appendChild(newRow);
                                    }

                                    // Add to medicines list display
                                    medicinesHtml += `
                                        <div class="medicine-item">
                                            <div class="medicine-header">
                                                <span class="medicine-name">${medicine.med_name}</span>
                                            </div>
                                            <div class="medicine-details">
                                                <div>
                                                    <label>Dosage:</label>
                                                    <span>${medicine.dosage}</span>
                                                </div>
                                                <div>
                                                    <label>Frequency:</label>
                                                    <span>${medicine.frequency}</span>
                                                </div>
                                                <div>
                                                    <label>Quantity:</label>
                                                    <span>${medicine.quantity}</span>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                });
                            } else {
                                medicinesHtml = '<p>No medicines prescribed</p>';
                            }
                            medicinesDiv.innerHTML = medicinesHtml;

                            // Update special notes if any
                            if (response.prescription.special_note) {
                                notesDiv.style.display = 'block';
                                document.getElementById('prescription-note-text').textContent = response.prescription.special_note;
                            } else {
                                notesDiv.style.display = 'none';
                            }

                            // Update total price after adding medicines
                            updateTotalPrice();
                        } else {
                            medicinesDiv.innerHTML = 'Prescription details not found';
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        medicinesDiv.innerHTML = '<div class="error">Error loading prescription details</div>';
                    }
                } else {
                    console.error('Error loading prescription details:', xhr.status);
                    medicinesDiv.innerHTML = '<div class="error">Error loading prescription details</div>';
                }
            };
            
            xhr.onerror = function(e) {
                console.error('Network error while loading prescription details:', e);
                medicinesDiv.innerHTML = '<div class="error">Error loading prescription details</div>';
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
            let formData = new FormData(this);

            // Clear any existing medicine data
            for (let key of formData.keys()) {
                if (key.startsWith('medicines[')) {
                    formData.delete(key);
                }
            }

            // Collect medicine data from the new structure
            medicineRows.forEach((row, index) => {
                const medicineName = row.querySelector('.medicine-name').textContent;
                const quantitySpan = row.querySelector('.medicine-quantity');
                
                if (medicineName && quantitySpan) {
                    const medicine = <?= json_encode($medicines) ?>.find(m => m.med_name === medicineName);
                    if (medicine) {
                        formData.append(`medicines[${index}][med_id]`, medicine.med_id);
                        formData.append(`medicines[${index}][quantity]`, quantitySpan.textContent);
                        hasValidMedicine = true;
                    }
                }
            });

            if (!hasValidMedicine) {
                isValid = false;
                errorMessage = 'Please select at least one medicine with a valid quantity';
            }

            if (!isValid) {
                alert(errorMessage);
                return;
            }

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

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