<?php 

class RoleModel
{
	
	use Model;

	protected $table = 'roles';

	protected $allowedColumns = [

	        'user_id',
            'role'
	];

	public function deleteRole($user_id, $user_role)
{
    $query = "DELETE FROM $this->table WHERE user_id = :user_id AND role = :user_role";
    $params = ['user_id' => $user_id, 'user_role' => $user_role];

    $result = $this->query($query, $params);

    return $result ? true : false;
}

}