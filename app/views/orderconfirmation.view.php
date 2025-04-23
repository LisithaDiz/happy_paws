<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <style>
        .confirmation-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .order-details {
            margin-top: 20px;
        }

        .order-details h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding: 8px 0;
        }

        .detail-label {
            font-weight: bold;
            width: 200px;
        }

        .detail-value {
            flex: 1;
        }

        .back-button {
            display: inline-block;
            background-color: #d8544c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #c14841;
        }
    </style>
</head>
<body>
    <?php include('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar.php'); ?>
        
        <div class="confirmation-container">
            <?php if(isset($success_message)): ?>
                <div class="success-message">
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <div class="order-details">
                <h2>Order Details</h2>
                
                <div class="detail-row">
                    <div class="detail-label">Order ID:</div>
                    <div class="detail-value"><?= htmlspecialchars($order->order_id) ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Pharmacy:</div>
                    <div class="detail-value"><?= htmlspecialchars($pharmacy->name) ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Pet:</div>
                    <div class="detail-value"><?= htmlspecialchars($pet->pet_name) ?> (<?= htmlspecialchars($pet->pet_type) ?>)</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Total Price:</div>
                    <div class="detail-value">$<?= number_format($order->total_price, 2) ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Order Date:</div>
                    <div class="detail-value"><?= date('F j, Y, g:i a', strtotime($order->order_date)) ?></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Status:</div>
                    <div class="detail-value"><?= ucfirst(htmlspecialchars($order->status)) ?></div>
                </div>
            </div>

            <a href="<?=ROOT?>/PetOwnerDash" class="back-button">Back to Dashboard</a>
        </div>
    </div>

    <?php include('components/footer.php'); ?>
</body>
</html> 