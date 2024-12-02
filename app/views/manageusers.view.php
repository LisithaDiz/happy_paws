<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/manageusers.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>Manage Users - Admin Dashboard</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar1.php'); ?>
        <!-- Main content area -->
        <div class="main-content">
        <div class="user-management">
    <h2>Manage Users</h2>

    <!-- Pet Owners -->
    <div class="user-section">
        <h3>Pet Owners</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PO001</td>
                    <td>Samal Wijesinghe</td>
                    <td>samal@example.com</td>
                    <td>Pet Owner</td>
                    <td>Active</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/PO001" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/PO001" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/SuspendUser/PO001" class="btn-delete">Suspend</a>
                    </td>
                </tr>
                <tr>
                    <td>PO002</td>
                    <td>Anura Kumara</td>
                    <td>Anura@example.com</td>
                    <td>Pet Owner</td>
                    <td>Active</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/PO002" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/PO002" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/SuspendUser/PO002" class="btn-delete">Suspend</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Vets -->
    <div class="user-section">
        <h3>Vets</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>VET001</td>
                    <td>Dr. Dumindu</td>
                    <td>dumindu@example.com</td>
                    <td>Veterinarian</td>
                    <td>Active</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/VET001" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/VET001" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/SuspendUser/VET001" class="btn-delete">Suspend</a>
                    </td>
                </tr>
                <tr>
                    <td>VET002</td>
                    <td>Dr. Lisitha Rodriguez</td>
                    <td>lisitha.rodriguez@example.com</td>
                    <td>Veterinarian</td>
                    <td>Active</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/VET002" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/VET002" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/SuspendUser/VET002" class="btn-delete">Suspend</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pet Sitters -->
    <div class="user-section">
        <h3>Pet Sitters</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PS001</td>
                    <td>Sarah Sula</td>
                    <td>sarah.sulan@example.com</td>
                    <td>Pet Sitter</td>
                    <td>Active</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/PS001" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/PS001" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/SuspendUser/PS001" class="btn-delete">Suspend</a>
                    </td>
                </tr>
                <tr>
                    <td>PS002</td>
                    <td>Anji Nisansala</td>
                    <td>anji@example.com</td>
                    <td>Pet Sitter</td>
                    <td>Pending</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/PS002" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/PS002" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/ApproveUser/PS002" class="btn-verify">Approve</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pet Care Centers -->
    <div class="user-section">
        <h3>Pet Care Centers</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PCC001</td>
                    <td>Happy Paws Pet Spa</td>
                    <td>info@happypawsspa.com</td>
                    <td>Pet Care Center</td>
                    <td>Active</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/PCC001" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/PCC001" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/SuspendUser/PCC001" class="btn-delete">Suspend</a>
                    </td>
                </tr>
                <tr>
                    <td>PCC002</td>
                    <td>Paw-fect Pals Pet Resort</td>
                    <td>info@pawfectpals.com</td>
                    <td>Pet Care Center</td>
                    <td>Active</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/PCC002" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/PCC002" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/SuspendUser/PCC002" class="btn-delete">Suspend</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pharmacies -->
    <div class="user-section">
        <h3>Pharmacies</h3>
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PHAR001</td>
                    <td>Happy Paws Pharmacy</td>
                    <td>pharmacy@happypaws.com</td>
                    <td>Pharmacy</td>
                    <td>Active</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/PHAR001" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/PHAR001" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/SuspendUser/PHAR001" class="btn-delete">Suspend</a>
                    </td>
                </tr>
                <tr>
                    <td>PHAR002</td>
                    <td>City Pet Pharmacy</td>
                    <td>info@citypetpharmacy.com</td>
                    <td>Pharmacy</td>
                    <td>Pending</td>
                    <td class="action-buttons">
                        <a href="<?=ROOT?>/ViewUser/PHAR002" class="btn-view">View</a>
                        <a href="<?=ROOT?>/EditUser/PHAR002" class="btn-edit">Edit</a>
                        <a href="<?=ROOT?>/ApproveUser/PHAR002" class="btn-verify">Approve</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="action-buttons" style="margin-top: 20px;">
        <a href="<?=ROOT?>/AddNewUser" class="btn-edit">Add New User</a>
    </div>
</div>
        </div>
    </div>

    <
</body>
</html>