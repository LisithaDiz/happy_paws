<?php 

class UserModel 
{
    use Model;

    protected $table = 'user';
    protected $allowedColumns = [
        'username',
        'email',
        'password',
        
    ];


    public function signup($data, $user_role) 
    {
        
        try {

                // Insert into users table using Model's insert function
                print_r($data);
                $this->insert($data);
                
                // Get the inserted user to get their ID
                $user = $this->first(['email' => $data['email']]);
                $data['user_id'] = $user->user_id;
                
                // checking
                // print_r($data);
                $roleModel = new RoleModel();
                
                
                if($user) {
                    
                    // Based on role, insert additional data
                    
                    switch($user_role) {
                        case 'petOwner':
                            $data['role'] = '1';
                            $roleModel->insert($data);
                            $petOwnerModel = new PetOwnerModel();
                            $petOwnerModel->insert($data);
                            break;
                            
                        case 'veterinary':
                            $data['role'] = '2';
                            $roleModel->insert($data);
                            $vetModel = new VetModel();
                            $vetModel->insert($data);
                            break;
                            
                        case 'petSitter':
                            $data['role'] = '3';
                            $roleModel->insert($data);
                            $petSitterModel = new PetSitterModel();
                            $petSitterModel->insert($data);
                            break;
                            
                        case 'petCareCenter':
                            $data['role'] = '4';
                            $roleModel->insert($data);
                            $careCenterModel = new CareCenterModel();
                            print_r($data);
                            $careCenterModel->insert($data);
                            break;
                    
                        case 'pharmacy':
                            $data['role'] = '5';
                            $roleModel->insert($data);
                            $pharmacyModel = new PharmacyModel();
                            $pharmacyModel->insert($data);
                            break;
                    }
                        
                    return true;
                }
            
            
            return false;
            
        } catch (Exception $e) {
            $this->errors['signup'] = "Signup failed: " . $e->getMessage();
            echo "----not working (user model)------";
            return false;
        }
    }

    public function authenticate($username, $password, $user_role)
    {
        $user = $this->first(['username' => $username]);
        $user_id = $user->user_id;
        $roleModel = new RoleModel();
        $u_role =$roleModel->first(['user_id' => $user_id]);
        
        // show($u_role->role);
        // show($user_role);

        if($user_role != $u_role->role){
            echo "role not found in user model";
            return false;
        }
        if ($user) {
            // Verify the password
            // if (password_verify($password, $user->password)) {
            //     return $user; // Authentication successful
            // }
            if ($password == $user->password) {
                    return $user;
            }
        }
        return false;
    }

    public function validate($data)
    {
        $this->errors = [];

        // Check if username has provided
        if (empty($data['username'])) {
            $this->errors['username'] = "Username is required.";
        }else {
            // Check if username has already taken
            $existingUsername = $this->where(['username' => $data['username']]);
            if (!empty($existingUsername)) {
                $this->errors['username'] = "Username is already taken.";
            }
        }

        // Check if email has provided
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email format is invalid.";
        } else {
            // Check if email has already registered
            $existingEmail = $this->where(['email' => $data['email']]);
            if (!empty($existingEmail)) {
                $this->errors['email'] = "Email is already registered.Please log in using your account";
            }
        }

        // Check if password has provided
        if (empty($data['password'])) {
            $this->errors['password'] = "Password is required.";
        } 

        // Return true if no errors, otherwise false
        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
    
}
