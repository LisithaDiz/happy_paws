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
                        <h3 class="stat-value"><?= count($data['pending_orders']) ?></h3>
                        <p class="stat-period">Awaiting Action</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="fas fa-check-circle"></i>
                    <div class="stat-info">
                        <p class="stat-label">Processed Orders</p>
                        <h3 class="stat-value"><?= count($data['processed_orders']) ?></h3>
                        <p class="stat-period">Total Processed</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="fas fa-chart-pie"></i>
                    <div class="stat-info">
                        <p class="stat-label">Acceptance Rate</p>
                        <h3 class="stat-value">
                            <?php 
                                $total = count($data['processed_orders']);
                                $accepted = count(array_filter($data['processed_orders'], function($order) {
                                    return $order['status'] === 'accepted';
                                }));
                                echo $total > 0 ? round(($accepted / $total) * 100) : 0;
                            ?>%
                        </h3>
                        <p class="stat-period">Overall Rate</p>
                    </div>
                </div>
            </div>

            <!-- Pending Orders Section -->
            <div class="data-section">
                <div class="section-card">
                    <h2><i class="fas fa-hourglass-half"></i> Pending Orders</h2>
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
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['pending_orders'] as $order): ?>
                                <tr>
                                    <td>#<?= $order['order_id'] ?></td>
                                    <td><?= $order['customer_name'] ?></td>
                                    <td>
                                        <span class="pet-name"><?= $order['pet_name'] ?></span>
                                        <span class="pet-type"><?= $order['pet_type'] ?></span>
                                    </td>
                                    <td><?= $order['medicine'] ?></td>
                                    <td><?= $order['quantity'] ?></td>
                                    <td>Rs. <?= number_format($order['total_price'], 2) ?></td>
                                    <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                                    <td class="actions">
                                        <button onclick="acceptOrder('<?= $order['order_id'] ?>')" class="btn-accept">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                        <button onclick="showDeclineModal('<?= $order['order_id'] ?>')" class="btn-decline">
                                            <i class="fas fa-times"></i> Decline
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Processed Orders Section -->
            <div class="data-section">
                <div class="section-card">
                    <h2><i class="fas fa-check-double"></i> Processed Orders</h2>
                    <div class="table-responsive">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Pet Details</th>
                                    <th>Medicine</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Processed Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['processed_orders'] as $order): ?>
                                <tr>
                                    <td>#<?= $order['order_id'] ?></td>
                                    <td><?= $order['customer_name'] ?></td>
                                    <td>
                                        <span class="pet-name"><?= $order['pet_name'] ?></span>
                                        <span class="pet-type"><?= $order['pet_type'] ?></span>
                                    </td>
                                    <td><?= $order['medicine'] ?></td>
                                    <td>Rs. <?= number_format($order['total_price'], 2) ?></td>
                                    <td>
                                        <span class="status-badge <?= $order['status'] ?>">
                                            <i class="fas fa-<?= $order['status'] === 'accepted' ? 'check' : 'times' ?>"></i>
                                            <?= ucfirst($order['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($order['processed_date'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
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
    
    <script src="<?=ROOT?>/assets/js/orders.js"></script>
</body>
</html>