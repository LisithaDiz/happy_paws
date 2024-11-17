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
    'Settings' => '/vet/settings',
];

$petowner = [
    'Dashboard' => '/petownerdash',
    'My Profile' => '/petownerprofile',
    'Appointments' => '/petownerappointments',
    'Pets' => '/petownerpets',
    'Prescriptions' => '/petowner/prescriptions',
    'Settings' => '/petowner/settings',
];

$petsitter = [
    'Dashboard' => '/petsitterdash',
    'My Profile' => '/petsitterprofile',
    'My Petsitting Jobs' => '/petsitter/jobs',
    'Available Pets' => '/petsitter/available-pets',
    'Settings' => '/petsitter/settings',
];

?>