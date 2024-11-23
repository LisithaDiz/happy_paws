<?php 


/**
 * User class
 */
class Vet
{
	
	use Model;

	protected $table = 'veterinary_surgeon';

	protected $allowedColumns = [

		'username',
		'email',
		'license_number', 
		'first_name', 
		'last_name', 
		'age', 
		'gender', 
		'district', 
		'city', 
		'contact_number', 
		'years_of_experience'
	];

	public function validate($data)
	{
		$this->errors = [];

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
		
		if(empty($data['terms']))
		{
			$this->errors['terms'] = "Please accept the terms and conditions";
		}

		if(empty($this->errors))
		{
			return true;
		}

		return false;
	}

	public static function getVetData() {
        // Placeholder data (you would query the database here)
        return [
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'password' => '********',
            'createdDate' => '2024-11-12',
            'licenseNo' => '123456',
            'firstName' => 'John',
            'lastName' => 'Doe',
            'age' => 35,
            'gender' => 'Male',
            'district' => 'Downtown',
            'city' => 'Metropolis',
            'contactNo' => '+123456789',
            'yearsOfExperience' => 10,
            'profilePicture' => 'assets/images/default-profile-picture.webp'
        ];
    }
	
}

    

