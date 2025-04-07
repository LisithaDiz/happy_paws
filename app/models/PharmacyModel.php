<?php 

class PharmacyModel
{
	
	use Model;

	protected $table = 'pharmacy';

	protected $allowedColumns = [

	        'user_id',
            'name',
            'district',
            'city',
            'street',
            'contact_no',
            'certificate'
	];

        public function getAllInfo(){

		$order_column = 'pharmacy_id';
    	        $query = "SELECT * FROM $this->table AS ph
                JOIN user AS u ON ph.user_id = u.user_id
                ORDER BY $order_column $this->order_type";

		return $this->query($query);

	}
	
}