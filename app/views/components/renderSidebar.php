<?php
// Define the ROOT constant if not already defined
if (!defined('ROOT')) {
    define('ROOT', '/your-base-url'); // Replace with your actual root URL
}

// Define the renderSidebar function before using it
function renderSidebar($root, $links) {
    $html = '<div class="sidebar"><ul>';
    foreach ($links as $name => $path) {
        $html .= '<li><a href="' . $root . $path . '">' . htmlspecialchars($name) . '</a></li>';
    }
    $html .= '</ul></div>';
    return $html;
}

// Define vetLinks array
$vet = [
    'Dashboard' => '/vetdash',
    'My Profile' => '/vetprofile',
    'Upcoming Appointments' => '/vetappoinment',
    'Appointment Requests' => '/vetrequest',
    'View Pets' => '/vet/view-patients',
    'Prescriptions' => '/vetprescription',
    'Settings' => '/vetsettings',
];

$petowner = [
    'Dashboard' => '/PetOwnerDash',
    'My Profile' => '/PetOwnerProfile',
    'Find Vet' => '/VetSearch',
    'Pets' => '/PetOwnerDashboard',
    // 'Prescriptions' => '/PetOwnerPrescriptions',
    'Pet Guardians' => '/PetOwnerGuardians',
    'Pharmacies' => '/PharmSearch', 
    // 'Settings' => '/PetPwnerSettings',
];

$petsitter = [
    'Dashboard' => '/petsitterdash',
    'My Profile' => '/petsitterprofile',
    'My Petsitting Jobs' => '/petsitterjobs',
    'Available Pets' => '/petsitter/available-pets',
    'Settings' => '/petsittersettings',
];

?>