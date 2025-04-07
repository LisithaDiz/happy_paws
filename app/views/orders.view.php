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
                                    <th>Pet Details</th>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($data['recent_orders'])): ?>
                                    <?php foreach($data['recent_orders'] as $order): ?>
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
                                            <td><?= date('M d, Y', strtotime($order->order_date)) ?></td>
                                            <td class="actions">
                                                <?php if($order->status === 'pending'): ?>
                                                    <button onclick="updateOrderStatus(<?= $order->order_id ?>, 'accepted')" class="accept-btn">
                                                        <i class="fas fa-check"></i> Accept
                                                    </button>
                                                    <button onclick="updateOrderStatus(<?= $order->order_id ?>, 'declined')" class="decline-btn">
                                                        <i class="fas fa-times"></i> Decline
                                                    </button>
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

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target == document.getElementById('declineModal')) {
            closeDeclineModal();
        }
    }
    </script>
</body>
</html>