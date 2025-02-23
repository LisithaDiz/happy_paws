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
                                                    <button onclick="acceptOrder('<?= $order->order_id ?>')" class="btn-accept">
                                                        <i class="fas fa-check"></i> Accept
                                                    </button>
                                                    <button onclick="showDeclineModal('<?= $order->order_id ?>')" class="btn-decline">
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
            <span class="close">&times;</span>
            <h2><i class="fas fa-times-circle"></i> Decline Order</h2>
            <form action="<?=ROOT?>/orders/updateStatus" method="POST">
                <input type="hidden" id="decline-order-id" name="order_id">
                <div class="form-group">
                    <label for="decline-reason">Reason for declining:</label>
                    <select id="decline-reason" name="decline_reason" required>
                        <option value="">Select a reason</option>
                        <option value="out_of_stock">Out of Stock</option>
                        <option value="prescription_required">Prescription Required</option>
                        <option value="invalid_order">Invalid Order</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="decline-notes">Additional Notes:</label>
                    <textarea id="decline-notes" name="notes" rows="3"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeDeclineModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check"></i> Confirm Decline
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>
    
    <script>
        const ROOT = '<?=ROOT?>';
    </script>
    <script src="<?=ROOT?>/assets/js/orders.js"></script>
</body>
</html>