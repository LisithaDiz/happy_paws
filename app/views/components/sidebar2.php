<div class="sidebar">
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
        <a href="<?=ROOT?>/logout" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<script src="<?=ROOT?>/assets/js/sidebar.js"></script>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">