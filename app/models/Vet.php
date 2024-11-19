<?php 


/**
 * User class
 */
class Vet  
{
	
	use Model;

	protected $table = 'veterinary_surgeon';

	protected $allowedColumns = [

		'f_name', 
		'l_name', 
		'age', 
		'gender', 
		'district', 
		'city', 
		'street', 
		'contact_no', 
		'years_exp'
	];

	public function getFirstVetDetails()    
	{
		// Define the SQL query
		$query = "SELECT user.username, user.email, veterinary_surgeon.license_no, 
						veterinary_surgeon.f_name, veterinary_surgeon.l_name, 
						veterinary_surgeon.age, veterinary_surgeon.gender, 
						veterinary_surgeon.district, veterinary_surgeon.city, 
						veterinary_surgeon.contact_no, 
						veterinary_surgeon.years_exp
				FROM user
				JOIN veterinary_surgeon 
				ON user.user_id = veterinary_surgeon.user_id 
				LIMIT 1";

		// Execute the query and store the result
		$result = $this->query($query);

		// Return the result
		return $result;
	}



	public function getById($id, $id_column = 'vet_id')
	{
		$sql = "SELECT * FROM veterinary_surgeon WHERE $id_column = :id";
		$params = [':id' => $id];
		$result = $this->query($sql, $params);  // Get result from query
		// Check if query was successful
		if ($result !== false) {
			return $result[0];  // Return the first row if results are found
		}
	
		return false;  // Return false if no result was found or query failed
	}
	




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

    

