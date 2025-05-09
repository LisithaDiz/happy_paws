<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetavailablehours.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Vet Prescriptions</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar3.php'); ?>

        <!-- Main content area -->
        <div class="main-content">
            <h2>Update Availability </h2>
            <form action="<?= ROOT ?>/VetAvailableHours/availableHours" method="POST" id="availabilityForm">
                <div id="availabilityContainer">
                    <div class="availability-group">
                        <select name="day_of_week[]" required>
                            <option value="">Select a day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                        <input type="time" name="start_time[]" required>
                        <input type="time" name="end_time[]" required>
                        <input type="number" name="number_of_appointments[]" min="1" placeholder="No. of Appointments" required>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" class="add-button" onclick="addAvailabilityRow()">+ Add More</button>
                    <button type="submit" class="submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <?php include ('components/footer.php'); ?>

    <script>
    function addAvailabilityRow() {
        const container = document.getElementById("availabilityContainer");
        const newRow = document.createElement("div");
        newRow.classList.add("availability-group");
        newRow.innerHTML = `
            <select name="day_of_week[]" required>
                <option value="">Select a day</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
            <input type="time" name="start_time[]" required>
            <input type="time" name="end_time[]" required>
            <input type="number" name="number_of_appointments[]" min="1" placeholder="No. of Appointments" required>
        `;
        container.appendChild(newRow);
    }
    </script>

</body>
</html>
