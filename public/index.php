<?php 

session_start();

require "../app/core/init.php";

DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

$app = new App;
$app->loadController();

require_once '../app/controllers/VetProfile.php'; // Adjust the path

// Check the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Routing logic
if ($requestUri === '/happy/public/vetprofile') {
    $controller = new VetProfile();
    $controller->vetprofile();

} elseif ($requestUri === '/happy/public/vet/delete') {
    // Call the delete method for vet profile
    $controller = new VetProfile();
    $controller->deleteVet(); // Hardcode user ID and vet ID for now in delete() method

} else {
    // Handle other routes or show a 404 error
    // echo "Page not found.";hgjm  
}

    