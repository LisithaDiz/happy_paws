<div class="sidebar">
     <!-- Add user profile section at top -->
     <div class="sidebar-profile">
        <div class="profile-image">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($_SESSION['profile_image']); ?>" alt="Profile">
        </div>
        <div class="profile-info">
            <h4><?= $_SESSION['vet_name'] ?? 'Vet' ?></h4>
            <p><?= $_SESSION['username'] ?? 'username' ?></p>
        </div>
    </div>

    <div class="sidebar-divider"></div>
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="<?=ROOT?>/vetDashboard" class="<?= ($currentPage == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-clinic-medical"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/vetProfile" class="<?= ($currentPage == 'profile') ? 'active' : '' ?>">
                    <i class="fas fa-user-md"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/vetAvailability" class="<?= ($currentPage == 'availability') ? 'active' : '' ?>">
                    <i class="fas fa-clock"></i>
                    <span>Upcoming <br>Appointments</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/vetAvailableHours" class="<?= ($currentPage == 'availablehours') ? 'active' : '' ?>">
                    <i class="fas fa-clock"></i>
                    <span>Availability</span>
                </a>
            </li>
            
            <li>
                <a href="<?=ROOT?>/vetMedRequest" class="<?= ($currentPage == 'medicine-request') ? 'active' : '' ?>">
                    <i class="fas fa-capsules"></i>
                    <span>Request Medicine</span>
                </a>
            </li>
            <!-- <li>
                <a href="<?=ROOT?>/vetTreatedPet" class="<?= ($currentPage == 'pets') ? 'active' : '' ?>">
                    <i class="fas fa-paw"></i>
                    <span>View Pets</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="<?=ROOT?>/vetPrescription" class="<?= ($currentPage == 'prescriptions') ? 'active' : '' ?>">
                    <i class="fas fa-prescription"></i>
                    <span>Prescriptions</span>
                </a>
            </li> -->
            
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
</div>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">