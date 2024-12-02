<div class="sidebar">
    

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
                <a href="<?=ROOT?>/PetOwnerAppointments" class="<?= ($currentPage == 'findvet') ? 'active' : '' ?>">
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
</div>
    <!-- <div class="sidebar-footer">
        <div class="user-info">
            <img src="<?=ROOT?>/assets/images/avatar.jpg" alt="User Avatar" class="user-avatar">
            <div class="user-details">
                <span class="user-name"><?= $_SESSION['USER']->name ?? 'Guest' ?></span>
                <span class="user-role">Pet Owner</span>
            </div>
        </div>
        <a href="<?=ROOT?>/logout" class="logout-btn" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div> --> 

<script src="<?=ROOT?>/assets/js/sidebar.js"></script>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">