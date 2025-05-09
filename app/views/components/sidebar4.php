<div class="sidebar">
    

    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="<?=ROOT?>/petsitter/dashboard" class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/petsitter/profile" class="<?= ($currentPage == 'profile') ? 'active' : '' ?>">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/petsitter/requests" class="<?= ($currentPage == 'requests') ? 'active' : '' ?>">
                    <i class="fas fa-bell"></i>
                    <span>View Requests</span>
                    <span class="notification-badge">3</span> <!-- Dynamic number from backend -->
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/petsitter/accepted" class="<?= ($currentPage == 'accepted') ? 'active' : '' ?>">
                    <i class="fas fa-check-circle"></i>
                    <span>Accepted Requests</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/petsitter/pets" class="<?= ($currentPage == 'pets') ? 'active' : '' ?>">
                    <i class="fas fa-paw"></i>
                    <span>View Pets</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/petsitter/availability" class="<?= ($currentPage == 'availability') ? 'active' : '' ?>">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Update Availability</span>
                </a>
            </li>
        </ul>
    </nav>

    
</div>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">