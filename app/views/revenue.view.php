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
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="revenue-wrapper">
        <div class="dashboard-container">
            <!-- Sidebar for pharmacy functionalities -->
            <div class="sidebar">
                <h3>Pharmacy Dashboard</h3>
                <ul>
                <li><a href="<?=ROOT?>/PharmProfile">My Profile</a></li>
                <li><a href="<?=ROOT?>/Revenue">Revenue</a></li>
                <li><a href="<?=ROOT?>/Orders">Orders</a></li>    
                <!-- <li><a href="<?=ROOT?>/pharmacy/transactions">Transcation History</a></li> -->
                <!-- <li><a href="<?=ROOT?>/pharmacy/settings">Settings</a></li> -->
                </ul>
            </div>

            <!-- Main content area -->
            <div class="main-content">
                <h1>Revenue Dashboard</h1>
                
                <div class="revenue-content">
                    <!-- Summary Cards -->
                    <div class="overview-cards">
                        <div class="card">
                            <h3>Total Revenue</h3>
                            <p class="amount">$<?= number_format($data['summary']['total_revenue']) ?></p>
                            <span class="period">Year 2024</span>
                        </div>
                        <div class="card">
                            <h3>Monthly Average</h3>
                            <p class="amount">$<?= number_format($data['summary']['monthly_average']) ?></p>
                            <span class="period">Last 12 Months</span>
                        </div>
                        <div class="card">
                            <h3>Top Product</h3>
                            <p class="product"><?= $data['summary']['top_product']['name'] ?></p>
                            <span class="sales"><?= number_format($data['summary']['top_product']['units']) ?> units</span>
                        </div>
                    </div>

                    <!-- Monthly Revenue Table -->
                    <section class="dashboard-overview">
                        <h2>Monthly Revenue Breakdown</h2>
                        <div class="table-container">
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
                                        <td>$<?= number_format($month['revenue']) ?></td>
                                        <td><?= number_format($month['orders']) ?></td>
                                        <td><?= $month['top_product'] ?></td>
                                        <td class="<?= $month['growth'] >= 0 ? 'positive' : 'negative' ?>">
                                            <?= ($month['growth'] >= 0 ? '+' : '') . $month['growth'] ?>%
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Top Products Table -->
                    <section class="dashboard-overview">
                        <h2>Top Selling Products</h2>
                        <div class="table-container">
                            <table class="products-table">
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
                                        <td>$<?= number_format($product['revenue']) ?></td>
                                        <td><?= $product['profit_margin'] ?>%</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Statistics Summary -->
                    <section class="contact">
                        <h2>Revenue Statistics</h2>
                        <div class="statistics-summary">
                            <div class="stat-item">
                                <label>Total Orders:</label>
                                <span><?= number_format($data['statistics']['total_orders']) ?></span>
                            </div>
                            <div class="stat-item">
                                <label>Average Growth:</label>
                                <span><?= $data['statistics']['average_growth'] ?>%</span>
                            </div>
                            <div class="stat-item">
                                <label>Average Profit Margin:</label>
                                <span><?= $data['statistics']['average_margin'] ?>%</span>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>
    
    <script src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>