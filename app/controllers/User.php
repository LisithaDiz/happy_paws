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
                'f_tname' => $_POST['firstname'],
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
    

    public function login() {
         
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            

            $roleMapping = [
                'petOwner'        => 1,
                'veterinary'      => 2,
                'petSitter'       => 3,
                'petCareCenter'   => 4,
                'pharmacy'        => 5,
            ];

            $user_role = trim($_POST['user_role']) ?? ''; // Assume the role is sent as a POST parameter
           

            // Validate and assign the user role
            if (array_key_exists($user_role, $roleMapping)) {
                $user_role = $roleMapping[$user_role];

            } else {
                redirect('login');
                die("Invalid role provided.");
            }
            
            $user = $this->userModel->authenticate($username,$password,$user_role);
            
            if (empty($user)) {
                echo "<script>
                        alert('Invalid username or password or user role.');
                        window.location.href = '" . ROOT . "/login';
                      </script>";
                exit();
            }
            
            
            if($user)

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                

                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['user_role'] = $user_role; 
                $_SESSION['user_status'] = $user->active_status;

                if($_SESSION['user_status'] =='1'){

                    switch ($user_role) {
                        case 1:
                            redirect('PetOwnerDashboard');
                            break;
                        case 2:
                            redirect('VetDashboard');
                            break;
                        case 3:
                            redirect('PetSitterDashboard');
                            break;
                        case 4:
                            redirect('CareCenterDashboard');
                            break;
                        case 5:
                            redirect('PharmacyDashboard');
                            break;
                        default:
                            echo "user role not working in the controller";
                            // redirect('unauthorized');

                            break;
                    }
                }
                else{
                     redirect('_404');
                }
                
                exit();
            } else {
               
                echo "Invalid username or password.";
                $this->view('login');
            }

    }
    
    public function logout() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401); 
            echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
            return;
        }
    
        $_SESSION = array();
        session_destroy();
    
        
        http_response_code(200); 
        echo json_encode(['status' => 'success', 'message' => 'Logged out successfully']);
    }

}    
