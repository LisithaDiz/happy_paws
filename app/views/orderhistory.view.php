<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/orderhistory.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include ('components/sidebar2.php'); ?>

        <!-- Main content -->
        <div class="main-content">
            <div class="welcome-section">
                <h1>Order History</h1>
                <p class="subtitle">View all past pharmacy orders</p>
            </div>

            <!-- Orders Table Section -->
            <div class="data-section">
                <div class="section-card">
                    <h2><i class="fas fa-history"></i> Processed Orders</h2>
                    <div class="table-responsive">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Pet Details</th>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Processed Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($data['orders'])): ?>
                                    <?php foreach($data['orders'] as $order): ?>
                                        <tr>
                                            <td>#<?= $order->order_id ?></td>
                                            <td><?= htmlspecialchars($order->customer_name) ?></td>
                                            <td>
                                                <span class="pet-name"><?= htmlspecialchars($order->pet_name) ?></span>
                                                <span class="pet-type"><?= htmlspecialchars($order->pet_type) ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($order->medicine) ?></td>
                                            <td><?= $order->quantity ?></td>
                                            <td>Rs. <?= number_format($order->total_price, 2) ?></td>
                                            <td>
                                                <span class="status-badge <?= $order->status ?>">
                                                    <?= ucfirst($order->status) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($order->processed_date)) ?></td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="showOrderDetails({
                                                    orderId: '<?= $order->order_id ?>',
                                                    customer: '<?= htmlspecialchars($order->customer_name) ?>',
                                                    medicine: '<?= htmlspecialchars($order->medicine) ?>',
                                                    total: '<?= number_format($order->total_price, 2) ?>',
                                                    status: '<?= $order->status ?>',
                                                    declineReason: '<?= htmlspecialchars($order->decline_reason ?? '') ?>',
                                                    paymentStatus: '<?= $order->payment_status ?>'
                                                })" class="view-details-btn">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="no-orders">No processed orders found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Management Section -->
            <div class="data-section">
                <div class="section-card">
                    <h2><i class="fas fa-money-bill-wave"></i> Payment Section</h2>
                    <div class="table-responsive">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Medicine</th>
                                    <th>Total Amount</th>
                                    <th>Order Date</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                    <th>Bill</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($data['orders'])): ?>
                                    <?php foreach($data['orders'] as $order): ?>
                                        <tr>
                                            <td>#<?= $order->order_id ?></td>
                                            <td><?= htmlspecialchars($order->customer_name) ?></td>
                                            <td><?= htmlspecialchars($order->medicine) ?></td>
                                            <td>Rs. <?= number_format($order->total_price, 2) ?></td>
                                            <td><?= date('M d, Y', strtotime($order->processed_date)) ?></td>
                                            <td>
                                                <span class="payment-status <?= $order->payment_status ?>">
                                                    <?= ucfirst($order->payment_status) ?>
                                                </span>
                                            </td>
                                            <td class="actions-cell">
                                                <label class="toggle-switch">
                                                    <input type="checkbox" 
                                                           onchange="markAsPaid(<?= $order->order_id ?>, this)"
                                                           <?= $order->payment_status === 'paid' ? 'checked' : '' ?>
                                                           <?= $order->payment_status === 'paid' ? 'disabled' : '' ?>>
                                                    <span class="toggle-slider">
                                                        <span class="pending-text">Mark as </span>
                                                        <span class="paid-text">Paid ✓</span>
                                                    </span>
                                                </label>
                                            </td>
                                            <td class="bill-cell">
                                                <?php if($order->payment_status === 'paid'): ?>
                                                    <button onclick="showBill(<?= htmlspecialchars(json_encode([
                                                        'orderId' => $order->order_id,
                                                        'customer' => $order->customer_name,
                                                        'medicine' => $order->medicine,
                                                        'quantity' => $order->quantity,
                                                        'total' => $order->total_price,
                                                        'date' => date('M d, Y', strtotime($order->processed_date)),
                                                        'status' => $order->payment_status
                                                    ])) ?>)" class="generate-bill-btn">
                                                        <i class="fas fa-file-invoice"></i> Generate Bill
                                                    </button>
                                                <?php else: ?>
                                                    <span class="bill-pending">Payment Pending</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="no-orders">No orders found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><i class="fas fa-info-circle"></i> Order Details</h2>
            <div class="order-details">
                <div class="detail-row">
                    <span class="label">Order ID:</span>
                    <span id="modal-order-id"></span>
                </div>
                <div class="detail-row">
                    <span class="label">Customer:</span>
                    <span id="modal-customer"></span>
                </div>
                <div class="detail-row">
                    <span class="label">Medicine:</span>
                    <span id="modal-medicine"></span>
                </div>
                <div class="detail-row">
                    <span class="label">Total Amount:</span>
                    <span id="modal-total"></span>
                </div>
                <div class="detail-row">
                    <span class="label">Status:</span>
                    <span id="modal-status" class="status-badge"></span>
                </div>
                <!-- Payment info for accepted orders -->
                <div id="payment-info-row" class="detail-row">
                    <span class="label">Payment Status:</span>
                    <span id="modal-payment-status" class="payment-status"></span>
                </div>
                <!-- Decline reason for declined orders -->
                <div id="decline-reason-row" class="detail-row">
                    <span class="label">Reason for Decline:</span>
                    <span id="modal-decline-reason" class="decline-reason"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this Bill Modal after your existing modal -->
    <div id="billModal" class="modal">
        <div class="modal-content bill-modal">
            <span class="close">&times;</span>
            <div id="billContent" class="bill-content">
                <div class="bill-header">
                    <h2>Payment Receipt</h2>
                    <img src="<?=ROOT?>/assets/images/happy-paws-logo.png" alt="Logo" class="bill-logo">
                </div>
                <div class="bill-info">
                    <div class="bill-row">
                        <span class="label">Order ID:</span>
                        <span id="bill-order-id"></span>
                    </div>
                    <div class="bill-row">
                        <span class="label">Date:</span>
                        <span id="bill-date"></span>
                    </div>
                    <div class="bill-row">
                        <span class="label">Customer:</span>
                        <span id="bill-customer"></span>
                    </div>
                </div>
                <div class="bill-details">
                    <table class="bill-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="bill-medicine"></td>
                                <td id="bill-quantity"></td>
                                <td id="bill-amount"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total Amount</td>
                                <td id="bill-total"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="bill-footer">
                    <div class="payment-info">
                        <p>Payment Status: <span class="status-badge accepted">Paid</span></p>
                        <p>Payment Method: Card Payment</p>
                    </div>
                    <button onclick="printBill()" class="print-bill-btn">
                        <i class="fas fa-print"></i> Print Bill
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JavaScript files -->
    <script src="<?=ROOT?>/assets/js/script.js"></script>
    <script>
        // Get the modal
        const modal = document.getElementById("orderDetailsModal");
        const span = document.getElementsByClassName("close")[0];

        // Function to open modal with order details
        function showOrderDetails(orderData) {
            document.getElementById("modal-order-id").textContent = "#" + orderData.orderId;
            document.getElementById("modal-customer").textContent = orderData.customer;
            document.getElementById("modal-medicine").textContent = orderData.medicine;
            document.getElementById("modal-total").textContent = "Rs. " + orderData.total;
            
            const statusElement = document.getElementById("modal-status");
            statusElement.textContent = orderData.status.charAt(0).toUpperCase() + orderData.status.slice(1);
            statusElement.className = "status-badge " + orderData.status;

            // Handle payment info for accepted orders
            const paymentInfoRow = document.getElementById("payment-info-row");
            if (orderData.status === 'accepted') {
                paymentInfoRow.style.display = 'flex';
                const paymentStatusElement = document.getElementById("modal-payment-status");
                paymentStatusElement.textContent = orderData.paymentStatus.charAt(0).toUpperCase() + orderData.paymentStatus.slice(1);
                paymentStatusElement.className = "payment-status " + orderData.paymentStatus;
            } else {
                paymentInfoRow.style.display = 'none';
            }

            // Handle decline reason for declined orders
            const declineReasonRow = document.getElementById("decline-reason-row");
            if (orderData.status === 'declined' && orderData.declineReason) {
                declineReasonRow.style.display = 'flex';
                document.getElementById("modal-decline-reason").textContent = orderData.declineReason;
            } else {
                declineReasonRow.style.display = 'none';
            }

            document.getElementById("orderDetailsModal").style.display = "flex";
        }

        // Close modal when clicking (x)
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function markAsPaid(orderId, checkbox) {
            if (!checkbox.checked) {
                return; // Don't proceed if unchecking
            }

            if (confirm('Are you sure you want to mark this order as paid?')) {
                // Send AJAX request to update payment status
                fetch(`<?=ROOT?>/orderhistory/updatePaymentStatus/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        payment_status: 'paid'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        checkbox.disabled = true; // Disable the checkbox after successful payment
                        // Optional: Show success message
                        const row = checkbox.closest('tr');
                        row.style.backgroundColor = '#f0fff4';
                        setTimeout(() => {
                            row.style.backgroundColor = '';
                        }, 1000);
                    } else {
                        checkbox.checked = false; // Revert checkbox if failed
                        alert('Failed to update payment status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    checkbox.checked = false; // Revert checkbox if error
                    alert('An error occurred while updating payment status');
                });
            } else {
                checkbox.checked = false; // Revert checkbox if cancelled
            }
        }

        // Add these functions after your existing JavaScript
        function showBill(orderData) {
            // Populate bill details
            document.getElementById('bill-order-id').textContent = '#' + orderData.orderId;
            document.getElementById('bill-date').textContent = orderData.date;
            document.getElementById('bill-customer').textContent = orderData.customer;
            document.getElementById('bill-medicine').textContent = orderData.medicine;
            document.getElementById('bill-quantity').textContent = orderData.quantity;
            document.getElementById('bill-amount').textContent = 'Rs. ' + orderData.total;
            document.getElementById('bill-total').textContent = 'Rs. ' + orderData.total;

            // Show the modal
            document.getElementById('billModal').style.display = 'flex';
        }

        function printBill() {
            window.print();
        }

        // Update the window onclick handler to include the bill modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('orderDetailsModal')) {
                document.getElementById('orderDetailsModal').style.display = "none";
            }
            if (event.target == document.getElementById('billModal')) {
                document.getElementById('billModal').style.display = "none";
            }
        }

        // Update the close button handler
        document.querySelectorAll('.close').forEach(function(closeBtn) {
            closeBtn.onclick = function() {
                this.closest('.modal').style.display = "none";
            }
        });
    </script>
</body>
</html> 