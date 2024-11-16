<?php 

class CareCenterModel
{
	
	use Model;

	protected $table = 'pet_care_center';

	protected $allowedColumns = [

	        'user_id',
            'name',
            'district',
            'city',
            'street',
            'contact',
            'certificate'
	];


	
}