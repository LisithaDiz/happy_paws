<!DOCTYPE html>
<html>
<head>
    <title>Prescription Details</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .prescription-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .prescription-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .prescription-header h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .prescription-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .info-item label {
            display: block;
            font-weight: bold;
            color: #666;
            margin-bottom: 5px;
        }

        .medicines-list {
            margin-top: 20px;
        }

        .medicine-item {
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 5px;
            margin-bottom: 10px;
            background: #f8f9fa;
        }

        .medicine-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .medicine-name {
            font-weight: bold;
            color: #333;
        }

        .medicine-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .special-notes {
            margin-top: 20px;
            padding: 15px;
            background: #fff3cd;
            border-radius: 5px;
        }

        .action-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="prescription-container">
        <div class="prescription-header">
            <h2>Prescription Details</h2>
        </div>

        <div class="prescription-info">
            <div class="info-item">
                <label>Pet Name</label>
                <div><?= htmlspecialchars($prescription->pet_name) ?></div>
            </div>
            <div class="info-item">
                <label>Veterinarian</label>
                <div><?= htmlspecialchars($prescription->vet_name) ?></div>
            </div>
            <div class="info-item">
                <label>Date Issued</label>
                <div><?= date('F j, Y', strtotime($prescription->created_at)) ?></div>
            </div>
            <div class="info-item">
                <label>Time Stamp</label>
                <div><?= date('g:i A', strtotime($prescription->time_stamp)) ?></div>
            </div>
        </div>

        <div class="medicines-list">
            <h3>Prescribed Medicines</h3>
            <?php foreach ($medicines as $medicine): ?>
                <div class="medicine-item">
                    <div class="medicine-header">
                        <span class="medicine-name"><?= htmlspecialchars($medicine->med_name) ?></span>
                    </div>
                    <div class="medicine-details">
                        <div>
                            <label>Dosage</label>
                            <div><?= htmlspecialchars($medicine->dosage) ?></div>
                        </div>
                        <div>
                            <label>Frequency</label>
                            <div><?= htmlspecialchars($medicine->frequency) ?></div>
                        </div>
                        <div>
                            <label>Quantity</label>
                            <div><?= htmlspecialchars($medicine->quantity) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($prescription->special_note)): ?>
            <div class="special-notes">
                <h4>Special Notes</h4>
                <p><?= nl2br(htmlspecialchars($prescription->special_note)) ?></p>
            </div>
        <?php endif; ?>

        <div class="action-buttons">
            <?php if (isset($is_pharmacy) && $is_pharmacy): ?>
                <a href="<?=ROOT?>/pharmacy/orders" class="btn btn-secondary">Back to Orders</a>
            <?php else: ?>
                <a href="<?=ROOT?>/petowner/prescriptions" class="btn btn-secondary">Back to Prescriptions</a>
                <a href="<?=ROOT?>/PlaceOrder/index/<?= $prescription->prescription_id ?>" class="btn btn-primary">Use this Prescription</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 