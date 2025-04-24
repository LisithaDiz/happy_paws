<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/managemedicine.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <title>Happy Paws - Manage Medicines</title>   

</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
    <?php include ('components/sidebar_admin.php'); ?>
        <div class="main-content">
            <h2>Add Medicines</h2>
                <div class="add-medicine">
                    <h3>Add Medicine</h3>
                    <form action="<?=ROOT?>/admin/addMedicine" method="POST">
                        <input type="text" name="med_name" placeholder="Medicine Name" required>
                        <input type="text" name="med_description" placeholder="Medicine Description" required>
                        <button type="submit" name="addMedicine">Add</button>
                    </form>
                </div>
            <h2>Search Medicines</h2>
            <!-- Search Bar -->
                <input type="text" name="search" placeholder="Search by name , description">
                

            <!-- Medicine List -->
            <div class="medicine-list">
                <h3>Medicine List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($medicines)) : ?>
                            <?php foreach ($medicines as $med) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($med->med_id) ?></td>
                                    <td><?= htmlspecialchars($med->med_name) ?></td>
                                    <td><?= htmlspecialchars($med->med_description) ?></td>
                                    <td>
                                        <!-- Pass med_id to the delete endpoint -->
                                        <form action="<?= ROOT ?>/admin/deleteMedicine" method="POST" style="display:inline;">
                                            <input type="hidden" name="med_id" value="<?= htmlspecialchars($med->med_id) ?>">
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this medicine?');">Delete</button><br/>
                                        </form>
                                        <!-- Pass medicine data to the Edit Modal -->
                                         <br/>
                                        <button class="btn-edit" onclick="openEditModal(<?= htmlspecialchars(json_encode($med)) ?>)">Edit</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="4">No medicines found.</td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

            

    <!-- Edit Medicine Modal -->
            <div id="editMedicineModal" class="modal">
                <div class="modal-content">
                    <h3>Edit Medicine</h3>
                    <form action="<?=ROOT?>/admin/updateMedicine" method="POST">
                        <input type="hidden" name="med_id" id="editId">
                        <input type="text" name="med_name" id="editName" placeholder="Medicine Name" required>
                        <input type="text" name="med_description" id="editDescription" placeholder="Medicine Description" required>
                        <button type="submit" name="updateMedicine">Update</button>
                        <button type="button" onclick="closeEditModal()">Cancel</button>
                    </form>
                </div>
            </div>
    

    <script>
        function openEditModal(medicine) {
            document.getElementById('editId').value = medicine.med_id;
            document.getElementById('editName').value = medicine.med_name;
            document.getElementById('editDescription').value = medicine.med_description;
            document.getElementById('editMedicineModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editMedicineModal').style.display = 'none';
        }
        document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.querySelector('input[name="search"]');
        const tableRows = document.querySelectorAll(".medicine-list tbody tr");

        searchInput.addEventListener("input", function () {
            const filter = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const name = row.querySelector("td:nth-child(2)")?.textContent.toLowerCase();
                const description = row.querySelector("td:nth-child(3)")?.textContent.toLowerCase();

                if (name && description && (name.includes(filter) || description.includes(filter))) {
                    row.style.display = ""; // Show the row
                } else {
                    row.style.display = "none"; // Hide the row
                }
            });
        });
        });


        <?php include ('components/footer_mini.php'); ?>
    </script>

</body>
</html>
