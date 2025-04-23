<div class="sidebar">
    <!-- Add user profile section at top -->
    <div class="sidebar-profile">
        <div class="profile-image">
            <img src="<?=ROOT?>/assets/images/happy-paws-logo.png" alt="Profile">
        </div>
        <div class="profile-info">
            <h4><?= $_SESSION['user_role'] ?? 'Admin' ?></h4>
            <p><?="------------" ?></p>
        </div>
    </div>

    <div class="sidebar-divider"></div>

    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="<?=ROOT?>/AdminDashboard" class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/AdminManageMedicine" class="<?= ($currentPage == 'medicine') ? 'active' : '' ?>">
                    <i class="fas fa-pills"></i>
                    <span>Manage Medicine</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/AdminManageCertificates" class="<?= ($currentPage == 'certificates') ? 'active' : '' ?>">
                    <i class="fas fa-certificate"></i>
                    <span>Manage Certificates</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/AdminManageUsers" class="<?= ($currentPage == 'users') ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    <span>Manage Users</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/AdminManageUserRequests" class="<?= ($currentPage == 'user-requests') ? 'active' : '' ?>">
                    <i class="fas fa-user-clock"></i>
                    <span>User Requests</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="<?=ROOT?>/logout" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>


<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">