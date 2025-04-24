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
               'ChatBox' =>['index'],
               'CareCenterProfile'=>['index'],
               'Pets'=>['getPetsByType'],
               'PetOwnerController'=>['addBookings'],
               'PetOwnerView_VetProfile'=>['index'],
               'PetOwnerView_SitterProfile'=>['index'],
               'PetOwnerView _CareCenterProfile'=>['index'],
               
               
               'PlaceOrder' => ['index', 'create', 'getPrescriptions'],
               'Orders' => ['createOrder'],
               'PetOwnerDash'=>['index']
            ], 

        
        '2' => ['VetDashboard' => ['index'],
                'VetProfile'=> ['index','updateVetDetails','vetprofileUpdate','deleteVet'],
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
                'PetSitterProfile' => ['index','updateSitterDetails','sitterprofileUpdate','deletesitter'], 
                'PetSitterAccepted' => ['index'], 
                'PetSitterPet' => ['index'], 
                'PetSitterAvailability' => ['index'], 
                'PetSitterRequest' => ['index'], 
                'ChatBox' =>['index'],

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
        'User' => ['login', 'signupProcess','logout','contactUs'],
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
