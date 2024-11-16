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

	
	
}