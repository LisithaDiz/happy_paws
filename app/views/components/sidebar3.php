<div class="sidebar">
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
                <a href="<?=ROOT?>/vetAppoinment" class="<?= ($currentPage == 'appointments') ? 'active' : '' ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/vetTreatedPet" class="<?= ($currentPage == 'pets') ? 'active' : '' ?>">
                    <i class="fas fa-paw"></i>
                    <span>View Pets</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/vetPrescription" class="<?= ($currentPage == 'prescriptions') ? 'active' : '' ?>">
                    <i class="fas fa-prescription"></i>
                    <span>Prescriptions</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/vetAvailability" class="<?= ($currentPage == 'availability') ? 'active' : '' ?>">
                    <i class="fas fa-clock"></i>
                    <span>Update Availability</span>
                </a>
            </li>
            <li>
                <a href="<?=ROOT?>/vetMedRequest" class="<?= ($currentPage == 'medicine-request') ? 'active' : '' ?>">
                    <i class="fas fa-capsules"></i>
                    <span>Request Medicine</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="<?=ROOT?>/assets/js/sidebar.js"></script>