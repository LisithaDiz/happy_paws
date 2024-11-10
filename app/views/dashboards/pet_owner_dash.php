<!-- <?php
session_start();
require_once 'db/db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$table = $_SESSION['table'];

// Construct the query without using prepared statements
$query = "SELECT * FROM $table WHERE owner_ID = '$user_id'";
$result = $conn->query($query);

if ($result) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('Error fetching user data.');</script>";
    exit();
}

?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../assets/happy-paws-logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="pet_owner_dash.css">
</head>
<body>
    <!-- Main horizontal navigation bar -->
    <nav class="top-nav">
        <div class="nav-left">
            <img src="../assests/happy-paws-logo.png" class="logo" alt="Logo">
        </div>
        <ul class="nav-right">
            <li><a href="pet_owner_dash.php">Home</a></li>
            <li><a href="view_profile.php">View Profile</a></li>
            <li><a href="notifications.php">Notifications</a></li>
            <li><a href="logout.php" class="logout-button">Logout</a></li>
        </ul>
    </nav>

    <!-- Main layout with a sidebar and content area -->
    <div class="main-container">
        <!-- Sidebar navigation for booking history -->
        <nav class="side-nav">
            <ul>
                <li><a href="booking_history.php">Booking History</a></li>
                <li><a href="manage_bookings.php">Manage Bookings</a></li>
            </ul>
        </nav>

        <!-- Content section -->
        <div class="content-area">
            <div class="content">
                <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
                <p>My dashboard.</p>
            </div>

            <!-- Right side for announcements -->
            <div class="announcement-container">
                <h2>Announcements</h2>
                <p>Latest updates and information.</p>
            </div>
        </div>
    </div>
</body>
</html>
