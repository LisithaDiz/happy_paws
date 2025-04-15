<?php 

class PetOwnerModel
{
	
	use Model;

	protected $table = 'pet_owner';

	protected $allowedColumns = [

			'user_id',
            'f_name',
            'l_name',
            'age',
            'district',
            'city',
            'street',
            'contact_no',
            'num_pets'
	];


	public function getPetOwnerDetails()    
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

		public function getAllInfo(){

			$order_column = 'owner_id';
			$query = "SELECT * 
						FROM $this->table AS po
						JOIN user AS u 
						ON po.user_id = u.user_id
						ORDER BY $order_column $this->order_type";
	
			return $this->query($query);
	
		}

		public function ownerDetailsVetView()
		{
			$ownerid = 1;
			$query = "SELECT * FROM pet_owner o
					JOIN user u ON o.user_id = u.user_id
					WHERE o.owner_id = :ownerid";

			$result = $this->query($query,['ownerid' => $ownerid]);
			return $result;
		}

		
	
}