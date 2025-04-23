<div class="sidebar">
    <!-- Add user profile section at top -->
    <div class="sidebar-profile">
        <div class="profile-image">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" alt="Profile">
        </div>
        <div class="profile-info">
            <h4><?= $_SESSION['pharmacy_name'] ?? 'Pharmacy' ?></h4>
            <p><?= $_SESSION['username']?? 'username' ?></p>
        </div>
    </div>

    <div class="sidebar-divider"></div>

    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="<?=ROOT?>/PharmacyDashboard" class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-clinic-medical"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/revenue" class="<?= ($currentPage == 'revenue') ? 'active' : '' ?>">
                    <i class="fas fa-chart-line"></i>
                    <span>Revenue</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/orders" class="<?= ($currentPage == 'orders') ? 'active' : '' ?>">
                    <i class="fas fa-prescription-bottle-alt"></i>
                    <span>Orders</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/PharmProfile" class="<?= ($currentPage == 'profile') ? 'active' : '' ?>">
                    <i class="fas fa-user-md"></i>
                    <span>My Profile</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-status">
            <span class="status-dot"></span>
            <span class="status-text">Online</span>
        </div>
        
        <a href="<?=ROOT?>/user/logout" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">