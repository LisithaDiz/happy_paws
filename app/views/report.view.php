<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/report.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <?php include ('components/sidebar2.php'); ?>

        <div class="main-content">
            <div class="report-header">
                <h1>Sales Report</h1>
                <div class="date-filter">
                    <form action="" method="GET" id="dateFilterForm">
                        <div class="date-inputs">
                            <div class="input-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($data['start_date']) ?>">
                            </div>
                            <div class="input-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($data['end_date']) ?>">
                            </div>
                        </div>
                        <button type="submit" class="filter-btn">Apply Filter</button>
                    </form>
                    <a href="<?=ROOT?>/report/download?start_date=<?= urlencode($data['start_date']) ?>&end_date=<?= urlencode($data['end_date']) ?>" class="download-btn">
                        <i class="fas fa-download"></i> Download Report
                    </a>
                </div>
            </div>

            <div class="report-summary">
                <div class="summary-card">
                    <i class="fas fa-shopping-cart"></i>
                    <div class="summary-info">
                        <h3>Total Orders</h3>
                        <p><?= number_format($data['sales_summary']->total_orders) ?></p>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-dollar-sign"></i>
                    <div class="summary-info">
                        <h3>Total Revenue</h3>
                        <p>Rs. <?= number_format($data['sales_summary']->total_revenue, 2) ?></p>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-chart-line"></i>
                    <div class="summary-info">
                        <h3>Average Order Value</h3>
                        <p>Rs. <?= number_format($data['sales_summary']->average_order_value, 2) ?></p>
                    </div>
                </div>
                <div class="summary-card">
                    <i class="fas fa-check-circle"></i>
                    <div class="summary-info">
                        <h3>Completed Orders</h3>
                        <p><?= number_format($data['sales_summary']->paid_orders) ?></p>
                    </div>
                </div>
            </div>

            <div class="report-details">
                <div class="medicine-sales">
                    <h2>Medicine Sales Details</h2>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Orders</th>
                                    <th>Quantity Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['medicine_sales'] as $medicine): ?>
                                <tr>
                                    <td><?= htmlspecialchars($medicine->med_name) ?></td>
                                    <td><?= number_format($medicine->order_count) ?></td>
                                    <td><?= number_format($medicine->total_quantity) ?></td>
                                    <td>Rs. <?= number_format($medicine->total_revenue, 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="monthly-revenue">
                    <h2>Monthly Revenue Details</h2>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Revenue</th>
                                    <th>Orders</th>
                                    <th>Top Product</th>
                                    <th>Growth</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['monthly_revenue'])): ?>
                                    <?php foreach ($data['monthly_revenue'] as $month): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($month['month']) ?></td>
                                        <td>Rs. <?= number_format($month['revenue'], 2) ?></td>
                                        <td><?= number_format($month['orders']) ?></td>
                                        <td><?= htmlspecialchars($month['top_product']) ?></td>
                                        <td class="<?= $month['growth'] >= 0 ? 'positive' : 'negative' ?>">
                                            <?= number_format($month['growth'], 2) ?>%
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No monthly revenue data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="order-stats">
                    <h2>Order Statistics</h2>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <h4>Accepted Orders</h4>
                            <p><?= number_format($data['sales_summary']->accepted_orders) ?></p>
                        </div>
                        <div class="stat-item">
                            <h4>Declined Orders</h4>
                            <p><?= number_format($data['sales_summary']->declined_orders) ?></p>
                        </div>
                        <div class="stat-item">
                            <h4>Pending Payments</h4>
                            <p><?= number_format($data['sales_summary']->pending_payments) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>

    <script>
        document.getElementById('dateFilterForm').addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (startDate > endDate) {
                e.preventDefault();
                alert('Start date cannot be later than end date');
            }
        });
    </script>
</body>
</html> 