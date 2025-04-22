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
            gap: 15px;
            margin-bottom: 15px;
            align-items: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .medicine-row:hover {
            background-color: #fff5f6;
        }

        .medicine-row select,
        .medicine-row input {
            flex: 1;
            margin: 0;
        }

        .remove-medicine {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .remove-medicine:hover {
            background-color: #c82333;
            transform: translateY(-1px);
        }

        .remove-medicine i {
            font-size: 0.9em;
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
            color: #d8544c;
        }

        .popup-close {
            background-color: #f8929c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .popup-close:hover {
            background-color: #d8544c;
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
