<?php 

class RoleModel
{
	
	use Model;

	protected $table = 'roles';

	protected $allowedColumns = [

	        'user_id',
            'role'
	];
	
}