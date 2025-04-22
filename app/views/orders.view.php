<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/orders.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .prescription-info {
            font-size: 0.9em;
            color: #666;
        }
        
        .prescription-info div {
            margin-bottom: 4px;
        }
        
        .no-prescription {
            color: #999;
            font-style: italic;
        }
        
        .btn-view {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 8px;
        }
        
        .btn-view:hover {
            background-color: #45a049;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-accepted {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-completed {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .prescription-popup {
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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .prescription-popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 800px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .prescription-popup-close {
            position: absolute;
            top: 15px;
            right: 15px;
            cursor: pointer;
            font-size: 24px;
            color: #666;
            background: none;
            border: none;
            padding: 5px;
            transition: color 0.2s ease;
        }

        .prescription-popup-close:hover {
            color: #333;
        }

        .prescription-details {
            margin-top: 20px;
        }

        .prescription-details h3 {
            margin-bottom: 20px;
            color: #2c3e50;
            font-size: 1.5em;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
        }

        .prescription-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .prescription-info div {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .prescription-info div strong {
            color: #495057;
            min-width: 120px;
        }

        .prescription-info div span {
            color: #2c3e50;
        }

        .special-notes {
            background-color: #fff3cd;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #ffc107;
        }

        .special-notes strong {
            color: #856404;
            display: block;
            margin-bottom: 8px;
        }

        .special-notes p {
            color: #856404;
            margin: 0;
            line-height: 1.5;
        }

        .prescription-medicines {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .prescription-medicines h4 {
            background-color: #e9ecef;
            padding: 15px 20px;
            margin: 0;
            color: #2c3e50;
            font-size: 1.2em;
        }

        .prescription-medicines ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .prescription-medicines li {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.2s ease;
        }

        .prescription-medicines li:last-child {
            border-bottom: none;
        }

        .prescription-medicines li:hover {
            background-color: #f8f9fa;
        }

        .medicine-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            display: block;
        }

        .medicine-details {
            color: #6c757d;
            font-size: 0.9em;
        }

        .medicine-details div {
            margin-top: 5px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }

        /* Loading Spinner */
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Table Styles */
        .orders-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .orders-table thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
        }

        .orders-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .orders-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .orders-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .orders-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Medicine List Styles */
        .medicine-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .medicine-list li {
            padding: 4px 0;
            color: #495057;
        }

        .medicine-list li:not(:last-child) {
            border-bottom: 1px dashed #dee2e6;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 0.9em;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .accept-btn {
            background-color: #28a745;
            color: white;
        }

        .accept-btn:hover {
            background-color: #218838;
        }

        .decline-btn {
            background-color: #dc3545;
            color: white;
        }

        .decline-btn:hover {
            background-color: #c82333;
        }

        .btn-view {
            background-color: #17a2b8;
            color: white;
        }

        .btn-view:hover {
            background-color: #138496;
        }

        /* Status Badge */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 500;
            text-align: center;
            display: inline-block;
            min-width: 80px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-accepted {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-completed {
            background-color: #cce5ff;
            color: #004085;
        }

        /* Prescription Info */
        .prescription-info {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .prescription-info div {
            margin-bottom: 4px;
            color: #495057;
        }

        .no-prescription {
            color: #6c757d;
            font-style: italic;
        }

        /* Table Responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -15px;
            padding: 0 15px;
        }

        @media (max-width: 768px) {
            .orders-table {
                display: block;
            }

            .orders-table thead {
                display: none;
            }

            .orders-table tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                padding: 15px;
            }

            .orders-table td {
                display: block;
                text-align: right;
                padding: 8px 15px;
                border: none;
            }

            .orders-table td:before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                color: #495057;
            }

            .action-buttons {
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include ('components/sidebar2.php'); ?>

        <!-- Main content -->
        <div class="main-content">
            <div class="welcome-section">
                <h1>Order Management</h1>
                <p class="subtitle">Manage and track pharmacy orders</p>
            </div>

            <!-- Order Stats -->
            <div class="stats-section">
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <div class="stat-info">
                        <p class="stat-label">Pending Orders</p>
                        <h3 class="stat-value"><?= number_format($data['order_stats']->pending_orders) ?></h3>
                        <p class="stat-period">Awaiting Action</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="fas fa-check-circle"></i>
                    <div class="stat-info">
                        <p class="stat-label">Accepted Orders</p>
                        <h3 class="stat-value"><?= number_format($data['order_stats']->accepted_orders) ?></h3>
                        <p class="stat-period">Total Accepted</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="fas fa-dollar-sign"></i>
                    <div class="stat-info">
                        <p class="stat-label">Total Revenue</p>
                        <h3 class="stat-value">Rs. <?= number_format($data['order_stats']->total_revenue, 2) ?></h3>
                        <p class="stat-period">All Time</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="fas fa-history"></i>
                    <div class="stat-info">
                        <p class="stat-label">Order History</p>
                        <h3 class="stat-value">View all past orders</h3>
                        <a href="<?=ROOT?>/OrderHistory" class="stat-link">View Details</a>
                    </div>
                </div>
            </div>

            
            <!-- Recent Orders Section -->
            <div class="data-section">
                <div class="section-card">
                    <h2><i class="fas fa-shopping-cart"></i> Recent Orders</h2>
                    <div class="table-responsive">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Pet Name</th>
                                    <th>Pet Type</th>
                                    <th>Medicines</th>
                                    <th>Total Price</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Prescription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($data['recent_orders'])): ?>
                                    <?php foreach($data['recent_orders'] as $order): ?>
                                        <tr>
                                            <td data-label="Order ID">#<?= $order->order_id ?></td>
                                            <td data-label="Customer"><?= htmlspecialchars($order->customer_name) ?></td>
                                            <td data-label="Pet Name"><?= htmlspecialchars($order->pet_name) ?></td>
                                            <td data-label="Pet Type"><?= htmlspecialchars($order->pet_type) ?></td>
                                            <td data-label="Medicines">
                                                <ul class="medicine-list">
                                                    <?php foreach ($order->medicines as $medicine): ?>
                                                        <li><?= htmlspecialchars($medicine->med_name) ?> (Qty: <?= $medicine->quantity ?>)</li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </td>
                                            <td data-label="Total Price">Rs. <?= number_format($order->total_price, 2) ?></td>
                                            <td data-label="Order Date"><?= date('Y-m-d', strtotime($order->order_date)) ?></td>
                                            <td data-label="Status">
                                                <span class="status-badge <?= $order->status ?>">
                                                    <?= ucfirst($order->status) ?>
                                                </span>
                                            </td>
                                            <td data-label="Prescription">
                                                <?php if ($order->prescription_id): ?>
                                                    <button class="action-btn btn-view" onclick="viewPrescription(<?= $order->prescription_id ?>)">
                                                        <i class="fas fa-file-medical"></i> View Prescription
                                                    </button>
                                                <?php else: ?>
                                                    <span class="no-prescription">No prescription</span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Actions" class="action-buttons">
                                                <?php if($order->status === 'pending'): ?>
                                                    <button onclick="updateOrderStatus(<?= $order->order_id ?>, 'accepted')" class="action-btn accept-btn">
                                                        <i class="fas fa-check"></i> Accept
                                                    </button>
                                                    <button onclick="updateOrderStatus(<?= $order->order_id ?>, 'declined')" class="action-btn decline-btn">
                                                        <i class="fas fa-times"></i> Decline
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No orders found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Decline Order Modal -->
    <div id="declineModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeclineModal()">&times;</span>
            <h2><i class="fas fa-times-circle"></i> Decline Order</h2>
            <div class="decline-form">
                <div class="form-group">
                    <label for="decline-reason">Reason for Declining:</label>
                    <textarea id="decline-reason" rows="4" placeholder="Please enter the reason for declining this order..."></textarea>
                </div>
                <div class="button-group">
                    <button onclick="closeDeclineModal()" class="cancel-btn">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button onclick="submitDeclineReason()" class="submit-btn">
                        <i class="fas fa-check"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this before the closing body tag -->
    <div class="prescription-popup" id="prescriptionPopup">
        <div class="prescription-popup-content">
            <span class="prescription-popup-close" onclick="closePrescriptionPopup()">&times;</span>
            <div id="prescriptionDetails"></div>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>
    
    <script>
        const ROOT = '<?=ROOT?>';
    </script>
    <script>
    let currentOrderId = null;

    function updateOrderStatus(orderId, status) {
        if (status === 'declined') {
            currentOrderId = orderId;
            document.getElementById('declineModal').style.display = 'flex';
            document.getElementById('decline-reason').value = ''; // Clear previous reason
        } else {
            sendStatusUpdate(orderId, status);
        }
    }

    function closeDeclineModal() {
        document.getElementById('declineModal').style.display = 'none';
        currentOrderId = null;
    }

    function submitDeclineReason() {
        const reason = document.getElementById('decline-reason').value.trim();
        if (!reason) {
            alert('Please provide a reason for declining the order.');
            return;
        }
        sendStatusUpdate(currentOrderId, 'declined', reason);
        closeDeclineModal();
    }

    function sendStatusUpdate(orderId, status, declineReason = null) {
        const formData = new FormData();
        formData.append('order_id', orderId);
        formData.append('status', status);
        if (declineReason) {
            formData.append('decline_reason', declineReason);
        }

        fetch('<?=ROOT?>/orders/updateStatus', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Server response:', text);
                    throw new Error('Invalid JSON response from server');
                }
            });
        })
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Failed to update order status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the order status. Please try again.');
        });
    }

    function viewPrescription(prescriptionId) {
        const popup = document.getElementById('prescriptionPopup');
        const detailsDiv = document.getElementById('prescriptionDetails');
        
        // Show loading state
        detailsDiv.innerHTML = `
            <div class="loading-spinner">
                <div class="spinner"></div>
            </div>
        `;
        popup.style.display = 'flex';

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
                        detailsDiv.innerHTML = `<div class="error-message">${response.error}</div>`;
                        return;
                    }

                    if (response.prescription) {
                        let html = `
                            <h3>Prescription Details</h3>
                            <div class="prescription-info">
                                <div>
                                    <strong>Date:</strong>
                                    <span>${new Date(response.prescription.created_at).toLocaleDateString()}</span>
                                </div>
                                <div>
                                    <strong>Veterinarian:</strong>
                                    <span>${response.prescription.vet_name}</span>
                                </div>
                                <div>
                                    <strong>Pet:</strong>
                                    <span>${response.prescription.pet_name}</span>
                                </div>
                            </div>
                        `;
                        
                        if (response.prescription.special_note) {
                            html += `
                                <div class="special-notes">
                                    <strong>Special Notes</strong>
                                    <p>${response.prescription.special_note}</p>
                                </div>
                            `;
                        }
                        
                        html += `
                            <div class="prescription-medicines">
                                <h4>Prescribed Medicines</h4>
                                <ul>
                        `;
                        
                        if (response.medicines && response.medicines.length > 0) {
                            response.medicines.forEach(medicine => {
                                html += `
                                    <li>
                                        <span class="medicine-name">${medicine.med_name}</span>
                                        <div class="medicine-details">
                                            <div><strong>Dosage:</strong> ${medicine.dosage || 'Not specified'}</div>
                                            <div><strong>Instructions:</strong> ${medicine.instructions || 'Not specified'}</div>
                                        </div>
                                    </li>
                                `;
                            });
                        } else {
                            html += '<li>No medicines prescribed</li>';
                        }
                        
                        html += `
                                </ul>
                            </div>
                        `;
                        
                        detailsDiv.innerHTML = html;
                    } else {
                        detailsDiv.innerHTML = '<div class="error-message">Prescription details not found</div>';
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    detailsDiv.innerHTML = '<div class="error-message">Error loading prescription details</div>';
                }
            } else {
                detailsDiv.innerHTML = '<div class="error-message">Error loading prescription details</div>';
            }
        };
        
        xhr.onerror = function() {
            detailsDiv.innerHTML = '<div class="error-message">Network error while loading prescription details</div>';
        };
        
        xhr.send();
    }

    function closePrescriptionPopup() {
        document.getElementById('prescriptionPopup').style.display = 'none';
    }

    // Close popup when clicking outside
    window.onclick = function(event) {
        const popup = document.getElementById('prescriptionPopup');
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    }
    </script>
</body>
</html>