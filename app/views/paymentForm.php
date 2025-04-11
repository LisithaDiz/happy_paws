<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="payment-container">
        <h2>Payment Form</h2>
        <form action="processPayment.php" method="POST">
            <div class="form-group">
                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter your card number" required>
            </div>
            <div class="form-group">
                <label for="expiryDate">Expiry Date:</label>
                <input type="month" id="expiryDate" name="expiryDate" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" placeholder="Enter CVV" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" value="100" readonly>
            </div>
            <button type="submit" class="submit-button">Proceed to Payment</button>
        </form>
    </div>
</body>
</html>
