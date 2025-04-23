<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/manageusers.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <title>Happy Paws - Manage Users</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
    <?php include ('components/sidebar_admin.php'); ?>
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
                    <th>Created</th>
                    <th>Status</th>
                    <th>Actions</th>
                </Or>
            </thead>
            <tbodyO
            <?php foreach ($data['petOwners'] as $petOwner): ?>
                    <tr>
                        <td><?= $petOwner->user_id ?></td>
                        <td><?= $petOwner->username ?></td>
                        <td><?= $petOwner->email ?></td>
                        <td><?= $petOwner->created_at ?></td> <!-- Adjust if the property name is different -->
                        <td><?= $petOwner->active_status ?></td>
                        <td class="action-buttons">
                            <form action="<?= ROOT ?>/ViewUser" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $petOwner->user_id ?>">
                                <button type="submit" class="btn-view">View</button>
                            </form>
                            <form action="<?= ROOT ?>/EditUser" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $petOwner->user_id ?>">
                                <button type="submit" class="btn-edit">Edit</button>
                            </form>
                            <form action="<?= ROOT ?>/SuspendUser" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $petOwner->user_id ?>">
                                <button type="submit" class="btn-delete">Suspend</button>
                            </form>
                        </td>
                    </tr>
            <?php endforeach; ?>

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
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data['vets'] as $vet): ?>
                <tr>
                    <td><?= $vet->user_id ?></td>
                    <td><?= $vet->username ?></td>
                    <td><?= $vet->email ?></td>
                    <td><?= $vet->created_at ?></td>
                    <td><?= $vet->active_status ?></td>
                    <td class="action-buttons">
                        <form action="<?= ROOT ?>/ViewUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $vet->user_id ?>">
                            <button type="submit" class="btn-view">View</button>
                        </form>
                        <form action="<?= ROOT ?>/EditUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $vet->user_id ?>">
                            <button type="submit" class="btn-edit">Edit</button>
                        </form>
                        <form action="<?= ROOT ?>/SuspendUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $vet->user_id ?>">
                            <button type="submit" class="btn-delete">Suspend</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>   
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
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data['petSitters'] as $petSitter): ?>
                <tr>
                    <td><?= $petSitter->user_id ?></td>
                    <td><?= $petSitter->username ?></td>
                    <td><?= $petSitter->email ?></td>
                    <td><?= $petSitter->created_at ?></td>
                    <td><?= $petSitter->active_status ?></td>
                    <td class="action-buttons">
                        <form action="<?= ROOT ?>/ViewUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $petSitter->user_id ?>">
                            <button type="submit" class="btn-view">View</button>
                        </form>
                        <form action="<?= ROOT ?>/EditUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $petSitter->user_id ?>">
                            <button type="submit" class="btn-edit">Edit</button>
                        </form>
                        <form action="<?= ROOT ?>/SuspendUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $petSitter->user_id ?>">
                            <button type="submit" class="btn-delete">Suspend</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
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
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data['careCenters'] as $careCenter): ?>
                <tr>
                    <td><?= $careCenter->user_id ?></td>
                    <td><?= $careCenter->username ?></td>
                    <td><?= $careCenter->email ?></td>
                    <td><?= $careCenter->created_at ?></td>
                    <td><?= $careCenter->active_status ?></td>
                    <td class="action-buttons">
                        <form action="<?= ROOT ?>/ViewUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $careCenter->user_id ?>">
                            <button type="submit" class="btn-view">View</button>
                        </form>
                        <form action="<?= ROOT ?>/EditUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $careCenter->user_id ?>">
                            <button type="submit" class="btn-edit">Edit</button>
                        </form>
                        <form action="<?= ROOT ?>/SuspendUser" method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $careCenter->user_id ?>">
                            <button type="submit" class="btn-delete">Suspend</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
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
                        <th>Created at</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data['pharmacies'] as $pharmacy): ?>
                    <tr>
                        <td><?= $pharmacy->user_id ?></td>
                        <td><?= $pharmacy->username ?></td>
                        <td><?= $pharmacy->email ?></td>
                        <td><?= $pharmacy->created_at ?></td>
                        <td><?= $pharmacy->active_status ?></td>
                        <td class="action-buttons">
                            <form action="<?= ROOT ?>/ViewUser" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $pharmacy->user_id ?>">
                                <button type="submit" class="btn-view">View</button>
                            </form>
                            <form action="<?= ROOT ?>/EditUser" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $pharmacy->user_id ?>">
                                <button type="submit" class="btn-edit">Edit</button>
                            </form>
                            <form action="<?= ROOT ?>/SuspendUser" method="POST" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $pharmacy->user_id ?>">
                                <button type="submit" class="btn-delete">Suspend</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
                </tbody>
            </table>
        </div>

        <div class="action-buttons" style="margin-top: 20px;">
            <a href="<?=ROOT?>/Signup_role" class="btn-edit">Add New User</a>
        </div>
    </div>
</div>
</div>

    <?php include ('components/footer_mini.php'); ?>
</body>
</html>