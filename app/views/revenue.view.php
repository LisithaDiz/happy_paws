<?php
if (empty($data)) {
    die("No data available");
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/pharmdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/revenue.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <!-- Sidebar for pharmacy functionalities -->
        <?php include ('components/sidebar2.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <div class="welcome-section">
                <h1>Revenue Analytics</h1>
                <p class="subtitle">Track your pharmacy's financial performance</p>
            </div>

            <!-- Summary Stats Cards -->
            <div class="stats-section">
                <div class="stat-card">
                    <i class="fas fa-dollar-sign"></i>
                    <div class="stat-info">
                        <p class="stat-label">Total Revenue</p>
                        <h3 class="stat-value">Rs. <?= number_format($data['summary']['total_revenue']) ?></h3>
                        <p class="stat-period">All Time</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="fas fa-chart-line"></i>
                    <div class="stat-info">
                        <p class="stat-label">Monthly Average</p>
                        <h3 class="stat-value">Rs. <?= number_format($data['summary']['monthly_average']) ?></h3>
                        <p class="stat-period">Per Month</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="fas fa-box"></i>
                    <div class="stat-info">
                        <p class="stat-label">Top Product</p>
                        <h3 class="stat-value"><?= $data['summary']['top_product']['name'] ?></h3>
                        <p class="stat-period"><?= number_format($data['summary']['top_product']['units']) ?> units sold</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="fas fa-shopping-cart"></i>
                    <div class="stat-info">
                        <p class="stat-label">Total Orders</p>
                        <h3 class="stat-value"><?= number_format($data['summary']['total_orders']) ?></h3>
                        <p class="stat-period">All Time</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-container">
                    <h2>Monthly Revenue Trend</h2>
                    <canvas id="revenueChart"></canvas>
                </div>
                
                <div class="chart-container">
                    <h2>Top Products Performance</h2>
                    <canvas id="productsChart"></canvas>
                </div>
            </div>

            <!-- Monthly Revenue Table -->
            <div class="data-section">
                <div class="section-card">
                    <h2><i class="fas fa-table"></i> Monthly Revenue Details</h2>
                    <div class="table-responsive">
                        <table class="revenue-table">
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
                                <?php foreach ($data['monthly_revenue'] as $month): ?>
                                <tr>
                                    <td><?= $month['month'] ?></td>
                                    <td>Rs. <?= number_format($month['revenue']) ?></td>
                                    <td><?= number_format($month['orders']) ?></td>
                                    <td><?= $month['top_product'] ?></td>
                                    <td class="<?= $month['growth'] >= 0 ? 'positive' : 'negative' ?>">
                                        <?= $month['growth'] ?>%
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top Products Table -->
            <div class="data-section">
                <div class="section-card">
                    <h2><i class="fas fa-box"></i> Top Products</h2>
                    <div class="table-responsive">
                        <table class="revenue-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Units Sold</th>
                                    <th>Revenue</th>
                                    <th>Profit Margin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['top_products'] as $product): ?>
                                <tr>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= number_format($product['units_sold']) ?></td>
                                    <td>Rs. <?= number_format($product['revenue']) ?></td>
                                    <td class="positive"><?= $product['profit_margin'] ?>%</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>
    
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($data['monthly_revenue'], 'month')) ?>,
            datasets: [{
                label: 'Monthly Revenue',
                data: <?= json_encode(array_column($data['monthly_revenue'], 'revenue')) ?>,
                borderColor: '#f87e76',
                backgroundColor: 'rgba(248, 126, 118, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($data['top_products'], 'name')) ?>,
            datasets: [{
                label: 'Revenue',
                data: <?= json_encode(array_column($data['top_products'], 'revenue')) ?>,
                backgroundColor: 'rgba(248, 126, 118, 0.8)',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html>