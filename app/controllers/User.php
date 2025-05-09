<?php

class User 
{
    use Controller;

    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function signupProcess() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "<script>
                    alert('Something went wrong!');
                    window.location.href = 'signup_role.php';
                </script>";
            exit();
        }

        $user_role = $_POST["user_role"];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ];

        

        if ($user_role == 'veterinary') {
            $data = array_merge($data, [
                'f_name' => $_POST['firstname'],
                'l_name' => $_POST['lastname'],
                'age' => $_POST['age'],
                'gender' => $_POST['gender'],
                'district' => $_POST['district'],
                'city' => $_POST['city'],
                'street' => $_POST['street'],
                'contact_no' => $_POST['contact'],
                'license_no' => $_POST['license'],
                'certificate' => $_FILES['vet_certificate'],
                'years_exp' => $_POST['years_exp'],
            ]);
        } elseif ($user_role == 'petSitter') {
            $data = array_merge($data, [
                'f_name' => $_POST['firstname'],
                'l_name' => $_POST['lastname'],
                'age' => $_POST['age'],
                'gender' => $_POST['gender'],
                'district' => $_POST['district'],
                'city' => $_POST['city'],
                'street' => $_POST['street'],
                'contact_no' => $_POST['contact'],
                'years_exp' => $_POST['years_exp'],
            ]);
        } elseif ($user_role == 'petOwner') {
            $data = array_merge($data, [
                'f_name' => $_POST['firstname'],
                'l_name' => $_POST['lastname'],
                'age' => $_POST['age'],
                'district' => $_POST['district'],
                'city' => $_POST['city'],
                'street' => $_POST['street'],
                'contact_no' => $_POST['contact'],
                'num_pets' => $_POST['pets'],
            ]);
        } elseif ($user_role == 'petCareCenter') {
            $data = array_merge($data,[
                'name' => $_POST['name'],
                'certificate' => $_FILES['certificate'],
                'district' => $_POST['district'],
                'city' => $_POST['city'],
                'street' => $_POST['street'],
                'contact_no' => $_POST['contact'],
            ]);
        } elseif ($user_role == 'pharmacy') {
            $data = array_merge($data,[
                'name' => $_POST['name'],
                'certificate' => $_FILES['certificate'],
                'district' => $_POST['district'],
                'city' => $_POST['city'],
                'street' => $_POST['street'],
                'contact_no' => $_POST['contact'],
            ]);
        }

        // to check data
        // print_r($data);

        if ($this->userModel->validate($data)) {

            if ($this->userModel->signup($data, $user_role)) {
                echo "Signup successful!";
                redirect('login');
            } else {
                echo "Something went wrong!";
            }
        } else {
            $this->loadView($user_role);
        }
    }
    private function loadView($user_role) {
        // Include the view and pass the user role to the view
        require_once  $this->view('signup');
    }
    

    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $user_role = trim($_POST['user_role']) ?? '';

        $roleMapping = [
            'petOwner'        => 1,
            'veterinary'      => 2,
            'petSitter'       => 3,
            'petCareCenter'   => 4,
            'pharmacy'        => 5,
        ];

        // Validate and assign the user role
        if (array_key_exists($user_role, $roleMapping)) {
            $user_role = $roleMapping[$user_role];
        } else {
            $error = "Invalid role provided.";
            $this->view('login', ['error' => $error]);
            return;
        }

        // Authenticate user
        $user = $this->userModel->authenticate($username, $password, $user_role);

        if (empty($user)) {
            $error = "Invalid username, password, or user role.";
            $this->view('login', ['error' => $error]);
            return;
        }

        if ($user) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['user_role'] = $user_role;
            $_SESSION['user_status'] = $user->active_status;

        

            if ($_SESSION['user_status'] == '1') {
                switch ($user_role) {
                    case 1:

                        $user_owner = new PetOwnerModel;
                        $user_=$user_owner->first(['user_id' => $_SESSION['user_id']]);
                        $_SESSION['owner_id'] = $user_->owner_id;

                        redirect('PetOwnerDash');
                        break;
                    case 2:
                        $user_vet = new VetModel;
                        $user_=$user_vet->first(['user_id' => $_SESSION['user_id']]);
                        $_SESSION['vet_id'] = $user_->vet_id;
                        
                        redirect('VetDashboard');
                        break;
                    case 3:
                        $user_sitter = new PetSitterModel;
                        $user_=$user_sitter->first(['user_id' => $_SESSION['user_id']]);
                        $_SESSION['sitter_id'] = $user_->sitter_id;
                        
                        redirect('PetSitterDashboard');
                        break;
                    case 4:
                        $user_center = new CareCenterModel;
                        $user_=$user_center->first(['user_id' => $_SESSION['user_id']]);
                        $_SESSION['care_center_id'] = $user_->care_center_id;
                        
                        redirect('CareCenterDashboard');
                        break;
                    case 5:
                        $user_pharmacy = new PharmacyModel;
                        $user_=$user_pharmacy->first(['user_id' => $_SESSION['user_id']]);
                        $_SESSION['pharmacy_id'] = $user_->pharmacy_id;
                        
                        redirect('PharmacyDashboard');
                        break;
                    default:
                        $error = "Unknown user role.";
                        $this->view('login', ['error' => $error]);
                        return;
                }
            } else {
                redirect('_404');
            }
        }
    } else {
        $this->view('login');
    }
}

    
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            session_destroy();
            redirect('login');
        } else {
            http_response_code(401);
            echo "Not logged in.";
        }
    }

    public function contactUs() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Trim the inputs
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $subject = trim($_POST['subject']);
            $message = trim($_POST['message']);
            $user_id =  !empty($_SESSION['user_id']) ?$_SESSION['user_id'] :'0';
            
            $response = [];
    
            // Validation
            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $response['error'] = "All fields are required!";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['error'] = "Invalid email format!";
            } elseif (strlen($message) < 10) {
                $response['error'] = "Message must be at least 10 characters!";
            } else {
                // Store in Database (Example)
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                    'user_id' => $user_id
                ];
    
                $contactModel = new ContactUsModel();
                $saved = $contactModel->addContactUs($data);
    
                if ($saved) {
                    $success = "Your message has been submitted!";
                    $_POST = []; 
                    $this->view('contactus', ['success' => $success]);
                } else {
                    $error = "Something went wrong. Please try again.";
                    $this->view('contactus', ['error' => $error]);

                }
            }
        }
        
}

}    
