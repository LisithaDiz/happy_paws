<header class="modern-header">
    <nav class="modern-nav">
        <a href="<?=ROOT?>/index.php" class="modern-logo">
            <img src="<?=ROOT?>/assets/images/happy-paws-logo.png" alt="Logo">
        </a>

        <div class="nav-center">
            <ul id="nav-menu">
                <li><a href="<?=ROOT?>/index.php" class="nav-link">Home</a></li>
                <li><a href="<?=ROOT?>/about" class="nav-link">About</a></li>
                <li><a href="<?=ROOT?>/#services" class="nav-link">Services</a></li>
                <li><a href="<?=ROOT?>/contactUs" class="nav-link">Contact</a></li>
            </ul>
        </div>

        <div class="nav-right">
            <div class="user-profile">
                <div class="user-icon" id="userDropdownBtn">
                    <span class="user-name">User</span>
                    <img src="<?=ROOT?>/assets/images/happy-paws-logo.png" alt="User Profile">
                </div>
                <ul class="dropdown-menu" id="userDropdown">
                    <li><a href="<?=ROOT?>/profile"><i class="fas fa-user"></i> My Profile</a></li>
                    <li><a href="<?=ROOT?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li class="dropdown-divider"></li>
                    <li><a href="<?=ROOT?>/user/logout" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
</header>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="<?=ROOT?>/assets/js/nav.js"></script>