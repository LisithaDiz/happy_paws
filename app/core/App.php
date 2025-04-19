<?php

class App
{
    private $controller = 'Home';
    private $method     = 'index';

    private $roleAccess = [
        'admin' => ['AdminLogin' => ['index'],
                    'AdminDashboard' => ['index'],
                    'AdminManageMedicine' => ['index'],
                    'Admin' =>['addMedicine','updateMedicine','deleteMedicine'],
                    'AdminManageCertificates' => ['index'],
                    'AdminManageUsers' => ['index'],
                    'AdminManageRequests' => ['index'],
                    'AdminManageUserRequests' => ['index'],

                    ],
        '1' => ['PetOwnerDashboard' => ['index'], 
               'PetDetails' => ['index', 'deletePet'], 
               'PetUpdate' => ['index', 'updatePetDetails'],
               'PetAdd' => ['index', 'createPet'],
               'PetOwnerProfile' => ['index'],
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
               'PetOwnerDash'=>['index'],
               'PetOwnerBookVet'=>['index','bookvet'],
               'PetOwner_Appointments'=>['index','cancelAppointment'],
               'PetOwner_Reschedule'=>['index','reschedulevet'],
               'ChatBox' =>['index']
            ], 

        
        '2' => ['VetDashboard' => ['index'],
                'VetProfile'=> ['index','updateVetDetails','vetprofile','deleteVet'],
                'VetAppoinment' => ['index','getAppointmentDetails','appointmentStatus'],
                'VetRequest' => ['index'],
                'VetTreatedPet' => ['index','treatedPetDetails'],
                'VetPrescription' => ['index'],
                'VetAvailability' => ['index','completeAppointment','cancelAppointment'],
                'VetMedRequest' => ['index','addMedicineRequest'],
                'VetSettings' => ['index'],
                'VetAvailableHours' => ['index','availableHours','removeSlot'],
                'VetView_PetOwnerProfile' =>['index'],
                'VetView_PetProfile' =>['index','issueprescription','updatemedicalrecord','insertmedicalrecord','deletemedicalrecord'],
                'ChatBox' =>['index']
                
        ],

        '3' => ['PetSitterDashboard' => ['index'],
                'PetSitterProfile' => ['index'], 
                'PetSitterAccepted' => ['index'], 
                'PetSitterPet' => ['index'], 
                'PetSitterAvailability' => ['index'], 
                'PetSitterRequest' => ['index'], 
                'ChatBox' =>['index']
            ], 

        '4' => ['CareCenterDashboard' => ['index'],
                 'CareCenterCage' => ['index'],
                'CareCenterAvailability'=> ['index'],
                'CareCenterProfile'=> ['index'],
                'ChatBox' =>['index']
                ],
        '5' => ['PharmacyDashboard' => ['index'],
                'PharmProfile'=> ['index'],
                'Revenue'=> ['index'],
                'Orders'=> ['index', 'updateStatus'],
                'Reviews'=> ['index'],
                'OrderHistory' => ['index', 'updatePayment', 'markAsPaid'],
                'ChatBox' =>['index']
            ],
        
    ];

    private $publicAccess = [
        'Home' => ['index'],
        '_404' => ['index'],
        'About' => ['index'],
        'Signup_role' => ['index'],
        'Signup' => ['index'],
        'Login' => ['index'],
        'User' => ['login', 'signupProcess','logout','contactUs'],
        'Adminlogin' => ['index','login'],
        'Admin' =>['adminLogin'],
        'ContactUs' =>['index'],

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
        if (true) {
                    call_user_func_array([$controller, $this->method], $URL);


        } else {
            // echo "   Error...controller not loading (in app)";
            // Redirect to unauthorized access page or show an error
            redirect('_404');
            exit();
        }
    }
}
