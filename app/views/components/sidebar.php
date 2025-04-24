<div class="sidebar">
    <!-- Add user profile section at top -->
    <div class="sidebar-profile">
        <div class="profile-image">
            <img src="<?=ROOT?>/assets/images/prof/vet_prof.webp" alt="Profile">
        </div>
        <div class="profile-info">
            <h4><?= $_SESSION['USER']->name ?? 'User' ?></h4>
            <p><?= $_SESSION['USER']->email ?? 'email@example.com' ?></p>
        </div>
    </div>

    <div class="sidebar-divider"></div>

    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="<?=ROOT?>/PetOwnerDash" class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/PetOwnerProfile" class="<?= ($currentPage == 'profile') ? 'active' : '' ?>">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/VetSearch" class="<?= ($currentPage == 'findvet') ? 'active' : '' ?>">
                    <i class="fas fa-user-md"></i>
                    <span>Find Vet</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/PetOwnerDashboard" class="<?= ($currentPage == 'pets') ? 'active' : '' ?>">
                    <i class="fas fa-paw"></i>
                    <span>My Pets</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/petOwnerGuardians" class="<?= ($currentPage == 'petguardians') ? 'active' : '' ?>">
                    <i class="fas fa-user-shield"></i>
                    <span>Pet Guardians</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/PharmSearch" class="<?= ($currentPage == 'pharmacies') ? 'active' : '' ?>">
                    <i class="fas fa-prescription-bottle-alt"></i>
                    <span>Pharmacies</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-status">
            <span class="status-dot"></span>
            <span class="status-text">Online</span>
        </div>
        <a href="<?=ROOT?>/logout" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<script src="<?=ROOT?>/assets/js/sidebar.js"></script>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">