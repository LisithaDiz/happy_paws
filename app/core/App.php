<?php

class App
{
    private $controller = 'Home';
    private $method     = 'index';

    private $roleAccess = [
        'admin' => ['AdminLogin' => ['index'],
                    'AdminDashboard' => ['index'],
                    'ManageMedicine' => ['index'],
                    'Admin' =>['addMedicine','updateMedicine','deleteMedicine'],
                    'ManageCertificates' => ['index'],
                    'ManageUsers' => ['index'],
                    'ManageRequests' => ['index'],
                    'ManageUserRequests' => ['index'],

                    ],
        '1' => ['PetOwnerDashboard' => ['index'], 
               'PetDetails' => ['index', 'deletePet'], 
               'PetUpdate' => ['index', 'updatePetDetails'],
               'PetAdd' => ['index', 'createPet'],
               'PetOwnerProfile' => ['index'],
               'PetOwnerAppointments' => ['index'],
               'VetSearch' => ['index'],
               'PetOwnerGuardians' => ['index'],
               'PetsitterSearch' => ['index'],
               'PetOwnerSitterSelection' => ['index'],
               'PetcareSearch' => ['index'],
               'PharmSearch' => ['index'],
               'Reviews' =>['index','edit','delete','add','insert'],
               'Reviews2' =>['index','edit','delete','add','insert'],
               'Reviews3' =>['index','edit','delete','add','insert'],
               'Reviews4' =>['index','edit','delete','add','insert'],
               'PetOwnerPlaceOrder' =>['index'],
               'PlaceOrder' => ['index', 'create', 'getPrescriptions'],
               'Orders' => ['createOrder'],
               'PetOwnerDash'=>['index']
            ], 

        
        '2' => ['VetDashboard' => ['index'],
                'VetProfile'=> ['index','updateVetDetails','vetprofile','deleteVet'],
                'VetAppoinment' => ['index','getAppointmentDetails'],
                'VetRequest' => ['index'],
                'VetTreatedPet' => ['index'],
                'VetPrescription' => ['index'],
                'VetAvailability' => ['index'],
                'VetMedRequest' => ['index','addMedicineRequest'],
                'VetSettings' => ['index']],

        '3' => ['PetSitterDashboard' => ['index'],
                'PetSitterProfile' => ['index'], 
                'PetSitterAccepted' => ['index'], 
                'PetSitterPet' => ['index'], 
                'PetSitterAvailability' => ['index'], 
                'PetSitterRequest' => ['index'], 
            ], 

        '4' => ['CareCenterDashboard' => ['index'],
                 'CareCenterCage' => ['index'],
                'CareCenterAvailability'=> ['index'],
                ],
        '5' => ['PharmacyDashboard' => ['index'],
                'PharmProfile'=> ['index'],
                'Revenue'=> ['index'],
                'Orders'=> ['index', 'updateStatus'],
                'Reviews'=> ['index'],
                'OrderHistory' => ['index', 'updatePayment', 'markAsPaid'],
                'Report' => ['index', 'download'],
            ],
        
    ];

    private $publicAccess = [
        'Home' => ['index'],
        '_404' => ['index'],
        'About' => ['index'],
        'Signup_role' => ['index'],
        'Signup' => ['index'],
        'Login' => ['index'],
        'User' => ['login', 'signupProcess','logout'],
        'Adminlogin' => ['index','login'],
        'Admin' =>['adminLogin'],
        'ContactUs' =>['index'],
        'Prescription' => ['view'],
    ];

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        return explode("/", trim($URL, "/"));
    }

    private function checkAccess($controller, $method)
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
            return false; 
        }

        $role = $_SESSION['user_role'];
        
        if (!isset($this->roleAccess[$role])) {
            return false;
        }
        
        if (isset($this->roleAccess[$role][$controller])) {
            return in_array($method, $this->roleAccess[$role][$controller], true);
        }
        
        return false;
    }

    private function isPublic($controller, $method)
    {
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
            require "../app/controllers/_404.php";
            $this->controller = "_404";
        }

        $controller = new $this->controller;
        $this->method = $URL[1] ?? $this->method;

        /** Check Access **/
        if ($this->isPublic($this->controller, $this->method) || $this->checkAccess($this->controller, $this->method)) {
            if (method_exists($controller, $this->method)) {
                unset($URL[1]);
                call_user_func_array([$controller, $this->method], $URL);
            } else {
                redirect('_404');
            }
        } else {
            redirect('_404');
        }
    }
}
