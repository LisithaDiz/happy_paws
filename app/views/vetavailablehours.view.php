<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetavailablehours.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <title>Happy Paws - My Availability</title>
</head>
<body>
<?php include('components/nav2.php'); ?>

<div class="dashboard-container">
    <?php include('components/sidebar_vet.php'); ?>

    <div class="main-content">
        <h2>Update Your Availability</h2>
        <p class="subtitle">Specify the days, time slots, and maximum appointments you can accept.</p>

            <?php if (!empty($currentAvailabilityDetails)): ?>
                <div class="availability-list">
                    <h3>Your Current Availability</h3>
                    <?php foreach ($currentAvailabilityDetails as $slot): ?>
                        <div class="availability-item">
                            <div class="slot-details">
                                <p><strong>Day:</strong> <?= htmlspecialchars($slot->day_of_week) ?></p>
                                <p><strong>Start Time:</strong> <?= htmlspecialchars($slot->start_time) ?></p>
                                <p><strong>End Time:</strong> <?= htmlspecialchars($slot->end_time) ?></p>
                            </div>
                            <form method="POST" action="<?= ROOT ?>/VetAvailableHours/removeSlot" class="remove-slot-form">
                                <input type="hidden" name="slot_id" value="<?= htmlspecialchars($slot->avl_id) ?>">
                                <button type="submit" class="remove-button" title="Remove Slot">Remove slot</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No availability slots added yet!</p>
            <?php endif; ?>



        <form action="<?= ROOT ?>/VetAvailableHours/availableHours" method="POST" id="availabilityForm">
            <div id="availabilityContainer">
                <!-- Availability Group Template -->
                <div class="availability-group">
                    <label>Day:</label>
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

                    <div class="time-inputs">
                        <div>
                            <label>Start Time:</label>
                            <input type="time" name="start_time[]" required>
                        </div>
                        <div>
                            <label>End Time:</label>
                            <input type="time" name="end_time[]" required>
                        </div>
                    </div>

                    <div class="appointment-limit">
                        <label>No. of Appointments:</label>
                        <input type="number" name="number_of_appointments[]" min="1" placeholder="e.g. 5" required>
                    </div>
                    <button type="button" class="remove-button" onclick="removeAvailabilityRow(this)">X</button>
                </div>
            </div>

            <div class="buttons">
                <button type="button" class="add-button" onclick="addAvailabilityRow()">+ Add Another Slot</button>
                <button type="submit" class="submit-button">Save Availability</button>
            </div>
        </form>
    </div>
</div>

<?php include('components/footer_mini.php'); ?>

<script>
function addAvailabilityRow() {
    const container = document.getElementById("availabilityContainer");
    const newRow = document.createElement("div");
    newRow.classList.add("availability-group");
    newRow.innerHTML = `
        <label>Day:</label>
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

        <div class="time-inputs">
            <div>
                <label>Start Time:</label>
                <input type="time" name="start_time[]" required>
            </div>
            <div>
                <label>End Time:</label>
                <input type="time" name="end_time[]" required>
            </div>
        </div>

        <div class="appointment-limit">
            <label>No. of Appointments:</label>
            <input type="number" name="number_of_appointments[]" min="1" placeholder="e.g. 5" required>
        </div>
        <button type="button" class="remove-button" onclick="removeAvailabilityRow(this)">X</button>
    `;
    container.appendChild(newRow);
}

function removeAvailabilityRow(button) {
    const row = button.parentElement;
    row.remove();
}
</script>



</body>
</html>

