<?php 

class PetSitterModel
{
	
	use Model;

	protected $table = 'pet_sitter';

	protected $allowedColumns = [

		    'user_id',
            'f_name',
            'l_name',
            'age',
            'gender',
            'district',
            'city',
            'street',
            'contact_no',
            'years_exp',
            'activity_status'
	];

  public function getSitterDetails($sitterid=null)    
	{
		if ($sitterid === null) {
			$sitterid = $_SESSION['sitter_id'];
		}

		$query = "SELECT *
				FROM user
				JOIN pet_sitter
				ON user.user_id = pet_sitter.user_id 
				WHERE pet_sitter.sitter_id = :sitterid";

		// Bind the parameter to avoid SQL injection
		$params = ['sitterid' => $sitterid];

		// Execute the query and store the result
		$result = $this->query($query, $params);
		

		// Return the result
		return $result;
	}

	public function getSitterDetailsOwnerView($sitterid)    
	{

		$query = "SELECT *
				FROM user
				JOIN pet_sitter
				ON user.user_id = pet_sitter.user_id 
				WHERE  pet_sitter.sitter_id= :sitterid";

		// Bind the parameter to avoid SQL injection
		$params = ['sitterid' => $sitterid];

		// Execute the query and store the result
		$result = $this->query($query, $params);
    

		// Return the result
		return $result;
	}

    public function getAllInfo(){

		$order_column = 'sitter_id';
    	$query = "SELECT * FROM $this->table AS ps
              JOIN user AS u ON ps.user_id = u.user_id
              ORDER BY $order_column $this->order_type";

		return $this->query($query);

	}
	
}