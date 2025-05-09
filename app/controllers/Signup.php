<?php

class Signup
{
    use Controller;

    private function loadView($user_role) {
        // Include the view and pass the user role to the view
        require_once  $this->view('signup');
    }
    
    
 

    // Load the view and pass the user role ..
    public function index()
    {
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: signup_role');
            exit();
        }
        $user_role = $_POST['user_role'];

         // Load the view and pass the user role ..
        $this->loadView($user_role);
       
    }
}