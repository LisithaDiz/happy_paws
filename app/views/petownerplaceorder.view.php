

<?php
$pets = [
    ['id' => 1, 'name' => 'Buddy'],
    ['id' => 2, 'name' => 'Max'],
    ['id' => 3, 'name' => 'Bella']
];

$prescriptions = [
    ['id' => 101, 'title' => 'Buddy', 'date' => '2024-11-01'],
    ['id' => 102, 'title' => 'Max', 'date' => '2024-11-15'],
    ['id' => 103, 'title' => 'Bella', 'date' => '2024-11-20']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/placeorder.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">

    <title>Place Order to Pharmacy</title>
</head>
<body>
    <!-- Navigation Bar -->
    <?php include('components/nav.php'); ?>

    <!-- Sidebar -->
    <?php
        include 'components/renderSidebar.php';
        echo renderSidebar(ROOT, $petowner);
    ?>

    <!-- Main Content -->
    <div class="dashboard-container">
        <h1 class="dashboard-heading">Place an Order to Pharmacy</h1>

        <!-- Place Order Form -->
        <div class="place-order-container">
            <form action="<?=ROOT?>/PlaceOrder" method="POST" class="place-order-form">
                <!-- Target Pharmacy -->
                <!-- <label for="pharmacy" class="form-label">Target Pharmacy:</label>
                <input type="text" name="pharmacy" id="pharmacy" class="form-input" value="" readonly> -->

                <!-- Select Pet -->
                <label for="pet" class="form-label">Select Pet:</label>
                <select name="pet" id="pet" class="form-select" required>
                    <option value="" disabled selected>Select a pet</option>
                    <?php foreach ($pets as $pet): ?>
                        <option value="<?=htmlspecialchars($pet['id'])?>"><?=htmlspecialchars($pet['name'])?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Select Prescription -->
                <label for="prescription" class="form-label">Select Prescription:</label>
                <select name="prescription" id="prescription" class="form-select" required>
    <option value="" disabled selected>Select a prescription</option>
    <?php foreach ($prescriptions as $prescription): ?>
        <option value="<?= htmlspecialchars($prescription['id']) ?>">
            <?= htmlspecialchars($prescription['title']) ?> (<?= htmlspecialchars($prescription['date']) ?>)
        </option>
    <?php endforeach; ?>
</select>


                <!-- Delivery Method -->
                <label for="delivery" class="form-label">Delivery Method:</label>
                <select name="delivery" id="delivery" class="form-select" required>
                    <option value="" disabled selected>Select delivery method</option>
                    <option value="pickup">Pickup</option>
                    <option value="home_delivery">Home Delivery</option>
                </select>

                <!-- Delivery Address -->
                <div id="delivery-address-container" style="display: none;">
                    <label for="delivery_address" class="form-label">Delivery Address:</label>
                    <textarea name="delivery_address" id="delivery_address" rows="3" class="form-textarea" placeholder="Enter delivery address"></textarea>
                </div>

                <label for="notes" class="form-label">Additional Notes:</label>
                <textarea name="notes" id="notes" rows="4" class="form-textarea" placeholder="Enter any special requests or additional details"></textarea>

                <button type="submit" class="submit-button">Submit Order</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include('components/footer.php'); ?>

    <script>
        // Toggle delivery address visibility based on selected delivery method
        document.getElementById('delivery').addEventListener('change', function () {
            const deliveryAddressContainer = document.getElementById('delivery-address-container');
            if (this.value === 'home_delivery') {
                deliveryAddressContainer.style.display = 'block';
            } else {
                deliveryAddressContainer.style.display = 'none';
            }
        });
    </script>
</body>
</html>
