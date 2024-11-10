<?php 


/**
 * User class
 */
class User
{
	
	use Model;

	protected $table = 'user';

	protected $allowedColumns = [

		'username',
		'email',
		'password',
	];

	public function signup()
	{
		echo("function signup");

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo("signup details post in");
				$user_role = $_POST['user_role'];
                $userData = [
	
                    'username' => htmlspecialchars(trim($_POST['username'])),
                    'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL),
                    'password' => htmlspecialchars(trim($_POST['password'])),
                ];
        
				if($user_role == 'petOwner')
				{
                
					$petOwnerData = [
						'user_id'=>
						'f_name' => htmlspecialchars(trim($_POST['full-name'])),
						'gender' => htmlspecialchars(trim($_POST['gender'])),
						'dob' => htmlspecialchars(trim($_POST['dob'])),
						'phone_number' => htmlspecialchars(trim($_POST['phone-number'])),
						'street_address' => htmlspecialchars(trim($_POST['street-address'])),
						'city' => htmlspecialchars(trim($_POST['city'])),
						'district' => htmlspecialchars(trim($_POST['district'])),
						'province' => htmlspecialchars(trim($_POST['province'])),
						'payment_method' => htmlspecialchars(trim($_POST['payment-method'])) 
                ];
				}	
        
              
                if ($this->userModel->validate($userData)) {
                    echo("validate done");
                    
                    $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        
                    if ($this->userModel->registerBuyer($userData, $buyerData)) {
                        echo "Registration successful!";
                        redirect('login');
                    } else {
                        echo "Something went wrong!";
                    }
                } else {
                    echo("validate not done");
                   
                    $this->view('buyerRegister', $userData);
                }
            } else {
                echo("registerBuyer else");
                $this->view('buyerRegister');
            }
        }



	}

	private function validate($data)
	{
		$this->errors = [];
		if(empty($data['username']))
		{
			$this->errors['username']="Username is required"; 
		}
		if(empty($data['email']))
		{
			$this->errors['email'] = "Email is required";
		}else
		if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
		{
			$this->errors['email'] = "Email is not valid";
		}
		
		if(empty($data['password']))
		{
			$this->errors['password'] = "Password is required";
		}
		
		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}
}