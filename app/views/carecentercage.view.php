<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cage Management</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/carecentercage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 40%;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
        }
        .close {
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    
    <div class="dashboard-container">
        <?php include ('components/sidebar5.php'); ?>


        <div class="main-content">
            <section id="search-filter" style="display: flex; align-items: center; gap: 10px;">
                <h2 style="margin-right: 10px;"><i class="fas fa-search"></i></h2>
                <input type="text" id="search" name="search" placeholder="Search..." style="flex: 1; padding: 5px;">
            </section>

            <section id="cage-list">
                <h2><i class="fas fa-list"></i> Cage List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Cage Name</th>
                            <th>Number of Cages</th>
                            <th>Size (H x L x W) (cm)</th>
                            <th>Designed For</th>
                            <th>Location</th>
                            <th>Additional Features</th>
                            <th>Available Cages</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cages)) : ?>
                            <?php foreach ($cages as $cage): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cage->cage_name ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($cage->number_of_cages ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($cage->height ?? 'N/A') . ' x ' . htmlspecialchars($cage->length ?? 'N/A') . ' x ' . htmlspecialchars($cage->width ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($cage->designed_for ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($cage->location ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($cage->additional_features ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($cage->available_cages ?? 'N/A'); ?></td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn-edit" 
                                            data-id="<?= $cage->id; ?>"
                                            data-cage-name="<?= htmlspecialchars($cage->cage_name); ?>"
                                            data-number-of-cages="<?= htmlspecialchars($cage->number_of_cages); ?>"
                                            data-height="<?= htmlspecialchars($cage->height); ?>"
                                            data-length="<?= htmlspecialchars($cage->length); ?>"
                                            data-width="<?= htmlspecialchars($cage->width); ?>"
                                            data-designed-for="<?= htmlspecialchars($cage->designed_for); ?>"
                                            data-location="<?= htmlspecialchars($cage->location); ?>"
                                            data-additional-features="<?= htmlspecialchars($cage->additional_features); ?>"
                                            data-available-cages="<?= htmlspecialchars($cage->available_cages); ?>"
                                            onclick="openEditModal(this)">
                                            Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <form method="POST" action="<?=ROOT?>/careCenter/deleteCage" style="display:inline;" onsubmit="return confirmDelete()">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($cage->id); ?>">
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8">No Cages Found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

            <!-- Add Cage Form -->
            <section id="add-cage">
                <h2><i class="fas fa-plus"></i> Add New Cage</h2>
                <form action="<?=ROOT?>/careCenter/addCage" method="POST" onsubmit="return validateCageForm()">
                    <label for="cage_name">Cage Name:</label>
                    <input type="text" id="cage_name" name="cage_name" required>

                    <label for="num_cages">Number of Cages:</label>
                    <input type="number" id="number_of_cages" name="number_of_cages" min="0" step="1" required>

                    <label for="cage_height">Cage Height (cm):</label>
                    <input type="number" id="height" name="height" min="0" step="0.1" required>

                    <label for="cage_length">Cage Length (cm):</label>
                    <input type="number" id="length" name="length" min="0" step="0.1" required>

                    <label for="cage_width">Cage Width (cm):</label>
                    <input type="number" id="width" name="width" min="0" step="0.1" required>

                    <label for="designed_for">Designed for:</label>
                    <select id="designed_for" name="designed_for" required>
                        <option value="">Select</option>
                        <option value="dogs">Dogs</option>
                        <option value="cats">Cats</option>
                    </select>

                    <label for="location">Location:</label>
                    <select id="location" name="location" required>
                        <option value="">Select</option>
                        <option value="indoor">Indoor</option>
                        <option value="outdoor(shelter)">Outdoor (In a Shelter)</option>
                    </select>

                    <label for="additional_features">Additional Features:</label>
                    <input type="text" id="additional_features" name="additional_features" required>

                    <label for="available_cages">Available Cages:</label>
                    <input type="number" id="available_cages" name="available_cages" min="0" step="1" required>

                    <button type="submit" name="add_cage">Add Cage</button>
                </form>
            </section>
        </div> 
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Cage</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form method="POST" action="<?=ROOT?>/careCenter/updateCage">
                <input type="hidden" id="edit_cage_id" name="id">

                <label>Cage Name:</label>
                <input type="text" id="edit_cage_name" name="cage_name" required>

                <label>Number of Cages:</label>
                <input type="number" id="edit_number_of_cages" name="number_of_cages" required>

                <label>Size (H x L x W) (cm):</label>
                <input type="number" id="edit_height" name="height" required>
                <input type="number" id="edit_length" name="length" required>
                <input type="number" id="edit_width" name="width" required>

                <label>Designed For:</label>
                <select id="edit_designed_for" name="designed_for" required>
                    <option value="dogs">Dogs</option>
                    <option value="cats">Cats</option>
                </select>

                <label>Location:</label>
                <select id="edit_location" name="location" required>
                    <option value="indoor">Indoor</option>
                    <option value="outdoor(shelter)">Outdoor (In a Shelter)</option>
                </select>

                <label>Additional Features:</label>
                <input type="text" id="edit_additional_features" name="additional_features" required>

                <label>Available Cages:</label>
                <input type="number" id="edit_available_cages" name="available_cages" required>

                <button type="submit">Update Cage</button>
            </form>
        </div>
    </div>

    <script>
        // Open Edit Modal
        function openEditModal(button) {
            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-cage-name');
            const numCages = button.getAttribute('data-number-of-cages');
            const height = button.getAttribute('data-height');
            const length = button.getAttribute('data-length');
            const width = button.getAttribute('data-width');
            const designedFor = button.getAttribute('data-designed-for');
            const location = button.getAttribute('data-location');
            const features = button.getAttribute('data-additional-features');
            const availableCages = button.getAttribute('data-available-cages');
            
            document.getElementById("edit_cage_id").value = id;
            document.getElementById("edit_cage_name").value = name;
            document.getElementById("edit_number_of_cages").value = numCages;
            document.getElementById("edit_height").value = height;
            document.getElementById("edit_length").value = length;
            document.getElementById("edit_width").value = width;
            document.getElementById("edit_designed_for").value = designedFor;
            document.getElementById("edit_location").value = location;
            document.getElementById("edit_additional_features").value = features;
            document.getElementById("edit_available_cages").value = availableCages;
            document.getElementById("editModal").style.display = "flex";
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }

        // Confirm Delete
        function confirmDelete() {
            return confirm("Are you sure you want to delete this cage?");
        }

        // Search Filter
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search");
            const tableRows = document.querySelectorAll("#cage-list table tbody tr");

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                tableRows.forEach((row) => {
                    const rowText = Array.from(row.children)
                        .slice(0, -1) // Exclude the last column (Actions)
                        .map(td => td.textContent.toLowerCase())
                        .join(" ");
                    row.style.display = rowText.includes(searchText) ? "" : "none";
                });
            }

            searchInput.addEventListener("input", filterTable);
        });
    </script>
</body>
</html>