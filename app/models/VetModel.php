<?php 

class VetModel
{
	
	use Model;

	protected $table = 'veterinary_surgeon';

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
            'license_no',
            'certificate',
			'years_exp'
	];

	

}