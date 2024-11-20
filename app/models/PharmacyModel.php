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


	
}