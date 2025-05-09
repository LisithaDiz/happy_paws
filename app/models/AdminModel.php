<?php 

class AdminModel
{
	
	use Model;

	protected $table = 'admin';

	protected $allowedColumns = [

	        'id',
            'username',
            'password'
	];


    public function adminAuthenticate($username, $password)
    {
        $user = $this->first(['username' => $username]);
        if(empty($user)){
            return false;
        }
        // var_dump($user);
        
        $user_id = $user->user_id;
        
        // show($u_role->role);
        // show($user_role);

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

    
	
}