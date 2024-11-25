<?php

class App
{
    private $controller = 'Home';
    private $method     = 'index';

    private $roleAccess = [
        'admin' => ['AdminLogin' => ['index'],
                    'AdminDashboard' => ['index'],
                    'ManageMedicine' => ['index'],
                    'Admin' =>['addMedicine','updateMedicine','deleteMedicine']
                    ],
        '1' => ['PetOwnerDashboard' => ['index']],

        
        '2' => ['VetDash' => ['index'],
                'VetProfile'=> ['index'],
                'VetAppoinment' => ['index'],
                'VetRequest' => ['index'],
                'VetTreatedpet' => ['index'],
                'VetPrescription' => ['index'],
                'VetSettings' => ['index']],

        '3' => ['PetSitterDashboard' => ['index']],
        '4' => ['CareCenterDashboard' => ['index']],
        '5' => ['PharmacyDashboard' => ['index']],
        
    ];

    private $publicAccess = [
        'Home' => ['index'],
        '-404' => ['index'],
        'About' => ['index'],
        'Signup_role' => ['index'],
        'Signup' => ['index'],
        'Login' => ['index'],
        'User' => ['login', 'signupProcess'],
        'Adminlogin' => ['index','login'],
        'Admin' =>['adminLogin']
    ];

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        return explode("/", trim($URL, "/"));
    }

    private function checkAccess($controller, $method)
    {
        //checking
        // var_dump($_SESSION['user_id']);
        // var_dump($_SESSION['user_role']);
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
            return false; 
        }

        $role = $_SESSION['user_role'];
        
        // Check if the role exists in roleAccess
        if (!isset($this->roleAccess[$role])) {
            return false;
        }
        // show($method);
        
        // Check if the controller exists for this role
        if (isset($this->roleAccess[$role][$controller])) {
            // var_dump( in_array($method, $this->roleAccess[$role][$controller], true));
            return in_array($method, $this->roleAccess[$role][$controller], true);
            
        }

        return false;
     }

    private function isPublic($controller, $method)
    {   //checking
        // echo($controller);
        // echo($method);
        // var_dump(isset($this->publicAccess[$controller]));
        return isset($this->publicAccess[$controller]) && in_array($method, $this->publicAccess[$controller]);
    }

    public function loadController()
    {
        $URL = $this->splitURL();

        /** Select controller **/
        $filename = "../app/controllers/" . ucfirst($URL[0]) . ".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            // Load 404 controller for invalid URLs
            require "../app/controllers/_404.php";
            $this->controller = "_404";
        }

        $controller = new $this->controller;

        /** Select method **/
        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }
        // var_dump($this->isPublic($this->controller, $this->method));
        // var_dump($this->checkAccess($this->controller, $this->method));

        /** Check Access **/
        if ($this->isPublic($this->controller, $this->method) || $this->checkAccess($this->controller, $this->method)) {
                    call_user_func_array([$controller, $this->method], $URL);

        } else {
            echo "   Error...controller not loading (in app)";
            // Redirect to unauthorized access page or show an error
            // redirect('_404');
            exit();
        }
    }
}
