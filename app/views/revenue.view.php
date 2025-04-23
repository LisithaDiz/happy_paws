<?php
if (empty($data)) {
    die("No data available");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Dashboard</title>
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
                    <div class="chart-wrapper">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container">
                    <h2>Top Products Performance</h2>
                    <div class="chart-wrapper">
                        <canvas id="productsChart"></canvas>
                    </div>
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
                                        <i class="fas fa-<?= $month['growth'] >= 0 ? 'arrow-up' : 'arrow-down' ?>"></i>
                                        <?= abs($month['growth']) ?>%
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
                    <h2><i class="fas fa-box"></i> Medicine Sales Details</h2>
                    <div class="top-products">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Units Sold</th>
                                        <th>Orders</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['top_products'] as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product->medicine_name) ?></td>
                                        <td><?= $product->total_quantity ?></td>
                                        <td><?= $product->total_orders ?></td>
                                        <td>Rs. <?= number_format($product->total_revenue, 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($data['monthly_revenue'], 'month')) ?>,
            datasets: [{
                label: 'Monthly Revenue',
                data: <?= json_encode(array_column($data['monthly_revenue'], 'revenue')) ?>,
                backgroundColor: 'rgba(216, 84, 76, 0.8)',
                borderColor: '#d8544c',
                borderWidth: 1,
                borderRadius: 4,
                barThickness: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 5,
                    right: 5,
                    top: 5,
                    bottom: 5
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 12,
                        family: "'Poppins', sans-serif",
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 11,
                        family: "'Poppins', sans-serif"
                    },
                    padding: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rs. ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20000,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 9
                        },
                        callback: function(value) {
                            return 'Rs. ' + value.toLocaleString();
                        },
                        stepSize: 100,
                        maxTicksLimit: 20,
                        padding: 5
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 9
                        },
                        padding: 5
                    },
                    categoryPercentage: 0.7,
                    barPercentage: 0.8
                }
            }
        }
    });

    // Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_map(function($product) { return $product->medicine_name; }, $data['top_products'])) ?>,
            datasets: [{
                data: <?= json_encode(array_map(function($product) { return $product->total_revenue; }, $data['top_products'])) ?>,
                backgroundColor: [
                    'rgba(216, 84, 76, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderColor: [
                    '#d8544c',
                    '#36a2eb',
                    '#ffce56',
                    '#4bc0c0',
                    '#9966ff'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            },
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 11
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 12,
                        family: "'Poppins', sans-serif",
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 11,
                        family: "'Poppins', sans-serif"
                    },
                    padding: 8,
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `Rs. ${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    </script>
</body>
</html>