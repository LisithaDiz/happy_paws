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
            'years_exp'
	];

    public function getAllInfo(){

		$order_column = 'sitter_id';
    	$query = "SELECT * FROM $this->table AS ps
              JOIN user AS u ON ps.user_id = u.user_id
              ORDER BY $order_column $this->order_type";

		return $this->query($query);

	}
	
}