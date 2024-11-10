<?php
require_once 'controllers/LoginController.php';

$loginController = new LoginController();

if ($_SERVER['REQUEST_URI'] === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginController->login();
} else {
    include 'views/login.php';
}
?>
