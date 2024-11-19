<?php

class User 
{
    use Controller;
	use Model;
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
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
            $this->view('signup', $data);
        }
    }
}