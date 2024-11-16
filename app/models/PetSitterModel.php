<?php 

class PetSitterModel
{
	
	use Model;

	protected $table = 'pet_sitter';

	protected $allowedColumns = [

		    'user_id',
            'firstname',
            'lastname',
            'age',
            'gender',
            'district',
            'city',
            'street',
            'contact_no',
            'years_exp'
	];

	
}