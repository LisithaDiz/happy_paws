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
if ($requestUri === '/happy_paws/public/vetprofile') {
    $controller = new VetProfile();
    $controller->vetprofile();
    
} else {
    // Handle other routes or show a 404 error
    echo "Page not found.";

}
    