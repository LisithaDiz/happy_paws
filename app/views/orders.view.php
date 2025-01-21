<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/orders.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    
        <div class="dashboard-container">
            <!-- Sidebar -->
            <?php include ('components/sidebar2.php'); ?>

            <!-- Main content -->
            <div class="main-content">
                <h1>Order Management</h1>
                
                <div class="orders-content">
                    <!-- Pending Orders Section -->
                    <section class="orders-section">
                        <h2>Pending Orders</h2>
                        <div class="table-container">
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
                                        <td><?= $order['order_id'] ?></td>
                                        <td><?= $order['customer_name'] ?></td>
                                        <td>
                                            <?= $order['pet_name'] ?><br>
                                            <span class="pet-type"><?= $order['pet_type'] ?></span>
                                        </td>
                                        <td><?= $order['medicine'] ?></td>
                                        <td><?= $order['quantity'] ?></td>
                                        <td>$<?= number_format($order['total_price'], 2) ?></td>
                                        <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                                        <td class="actions">
                                            <button onclick="acceptOrder('<?= $order['order_id'] ?>')" class="btn-accept">Accept</button>
                                            <button onclick="showDeclineModal('<?= $order['order_id'] ?>')" class="btn-decline">Decline</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Processed Orders Section -->
                    <section class="orders-section">
                        <h2>Processed Orders</h2>
                        <div class="table-container">
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
                                    <tr class="status-<?= $order['status'] ?>">
                                        <td><?= $order['order_id'] ?></td>
                                        <td><?= $order['customer_name'] ?></td>
                                        <td>
                                            <?= $order['pet_name'] ?><br>
                                            <span class="pet-type"><?= $order['pet_type'] ?></span>
                                        </td>
                                        <td><?= $order['medicine'] ?></td>
                                        <td>$<?= number_format($order['total_price'], 2) ?></td>
                                        <td>
                                            <span class="status-badge <?= $order['status'] ?>">
                                                <?= ucfirst($order['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($order['processed_date'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    

    <!-- Decline Order Modal -->
    <div id="declineModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Decline Order</h2>
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
                    <button type="button" class="btn-cancel" onclick="closeDeclineModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Confirm Decline</button>
                </div>
            </form>
        </div>
    </div>

   
    
    <script src="<?=ROOT?>/assets/js/orders.js"></script>
</body>
</html>