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

	
}