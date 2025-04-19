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
        }

        .prescription-popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
        }

        .prescription-popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 24px;
            color: #666;
        }

        .prescription-details {
            margin-top: 20px;
        }

        .prescription-details h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .prescription-info {
            margin-bottom: 15px;
        }

        .prescription-info div {
            margin-bottom: 8px;
        }

        .prescription-medicines {
            margin-top: 20px;
        }

        .prescription-medicines ul {
            list-style-type: none;
            padding: 0;
        }

        .prescription-medicines li {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            padding: 20px;
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
                                    <th>Quantities</th>
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
                                            <td>#<?= $order->order_id ?></td>
                                            <td><?= htmlspecialchars($order->customer_name) ?></td>
                                            <td><?= htmlspecialchars($order->pet_name) ?></td>
                                            <td><?= htmlspecialchars($order->pet_type) ?></td>
                                            <td>
                                                <ul>
                                                    <?php foreach ($order->medicines as $medicine): ?>
                                                        <li><?= htmlspecialchars($medicine->med_name) ?> (Qty: <?= $medicine->quantity ?>)</li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </td>
                                            <td>
                                                <?php foreach ($order->medicines as $medicine): ?>
                                                    <?= htmlspecialchars($medicine->quantity) ?><br>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>Rs. <?= number_format($order->total_price, 2) ?></td>
                                            <td><?= date('Y-m-d', strtotime($order->order_date)) ?></td>
                                            <td>
                                                <span class="status-badge <?= $order->status ?>">
                                                    <?= ucfirst($order->status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($order->prescription_id): ?>
                                                    <div class="prescription-info">
                                                        <div>Prescribed by: <?= htmlspecialchars($order->vet_name) ?></div>
                                                        <div>Date: <?= date('Y-m-d', strtotime($order->prescription_date)) ?></div>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="no-prescription">No prescription</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="actions">
                                                <?php if($order->status === 'pending'): ?>
                                                    <button onclick="updateOrderStatus(<?= $order->order_id ?>, 'accepted')" class="accept-btn">
                                                        <i class="fas fa-check"></i> Accept
                                                    </button>
                                                    <button onclick="updateOrderStatus(<?= $order->order_id ?>, 'declined')" class="decline-btn">
                                                        <i class="fas fa-times"></i> Decline
                                                    </button>
                                                <?php endif; ?>
                                                <?php if ($order->prescription_id): ?>
                                                    <button class="btn btn-view" onclick="viewPrescription(<?= $order->prescription_id ?>)">View Prescription</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No orders found</td>
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
        detailsDiv.innerHTML = '<div style="text-align: center; padding: 20px;">Loading prescription details...</div>';
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
                                <div><strong>Date:</strong> ${new Date(response.prescription.created_at).toLocaleDateString()}</div>
                                <div><strong>Vet:</strong> ${response.prescription.vet_name}</div>
                                <div><strong>Pet:</strong> ${response.prescription.pet_name}</div>
                            </div>
                        `;
                        
                        if (response.prescription.special_note) {
                            html += `
                                <div class="special-notes">
                                    <strong>Special Notes:</strong>
                                    <p>${response.prescription.special_note}</p>
                                </div>
                            `;
                        }
                        
                        html += `
                            <div class="prescription-medicines">
                                <h4>Prescribed Medicines:</h4>
                                <ul>
                        `;
                        
                        if (response.medicines && response.medicines.length > 0) {
                            response.medicines.forEach(medicine => {
                                html += `
                                    <li>
                                        <strong>${medicine.med_name}</strong>
                                        <div>Dosage: ${medicine.dosage || 'Not specified'}</div>
                                        <div>Instructions: ${medicine.instructions || 'Not specified'}</div>
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