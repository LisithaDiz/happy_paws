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
            if($this->validate($data)) {

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
            }
            
            return false;
            
        } catch (Exception $e) {
            $this->errors['signup'] = "Signup failed: " . $e->getMessage();
            echo "----not working (user model)------";
            return false;
        }
    }

  

    public function validate($data)
    {
        // $this->errors = [];

        // if(empty($data['username'])) {
        //     $this->errors['username'] = "Username is required";
        // }

        // if(empty($data['email'])) {
        //     $this->errors['email'] = "Email is required";
        // } else 
        // if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        //     $this->errors['email'] = "Email is not valid";
        // }

        // // Check if email exists using Model's first function
        // $user = $this->first(['email' => $data['email']]);
        // if($user) {
        //     $this->errors['email'] = "Email already exists";
        // }

        // if(empty($data['password'])) {
        //     $this->errors['password'] = "Password is required";
        // }

        // if(empty($this->errors)) {
        //     return true;
        // }

        // return false;
        return true;
    }
}