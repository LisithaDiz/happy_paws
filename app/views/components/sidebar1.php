<div class="sidebar">
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="<?=ROOT?>/AdminDashboard" class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/ManageMedicine" class="<?= ($currentPage == 'medicine') ? 'active' : '' ?>">
                    <i class="fas fa-pills"></i>
                    <span>Manage Medicine</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/ManageCertificates" class="<?= ($currentPage == 'certificates') ? 'active' : '' ?>">
                    <i class="fas fa-certificate"></i>
                    <span>Manage Certificates</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/ManageUsers" class="<?= ($currentPage == 'users') ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    <span>Manage Users</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/ManageUserRequests" class="<?= ($currentPage == 'user-requests') ? 'active' : '' ?>">
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

<script src="<?=ROOT?>/assets/js/sidebar.js"></script>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">