<?php 

/**
 * Main Model trait
 */
Trait Model
{
	use Database;

	protected $limit 		= 10;
	protected $offset 		= 0;
<<<<<<< HEAD
	protected $order_type 	= "asc";
=======
	protected $order_type 	= "desc";

>>>>>>> 0183fd1ef18e487236a95d335512ab343555c230
	protected $order_column = "user_id";

	public $errors 		= [];

	public function findAll()
	{
	 
		$query = "select * from $this->table order by $this->order_column $this->order_type limit $this->limit offset $this->offset";

		return $this->query($query);
	}

	public function where($data, $data_not = [])
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
		$query = "select * from $this->table where ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . " && ";
		}

		foreach ($keys_not as $key) {
			$query .= $key . " != :". $key . " && ";
		}
		
		$query = trim($query," && ");

		$query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
		$data = array_merge($data, $data_not);

		return $this->query($query, $data);
	}

	public function first($data, $data_not = [])
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
		$query = "select * from $this->table where ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . " && ";
		}

		foreach ($keys_not as $key) {
			$query .= $key . " != :". $key . " && ";
		}
		
		$query = trim($query," && ");

		$query .= " limit $this->limit offset $this->offset";
		$data = array_merge($data, $data_not);
		
		$result = $this->query($query, $data);
		// var_dump($result[0]);
		
		// var_dump($result);
		if($result){
			return $result[0];
		}
		
		return false;
	}

	public function insert($data)
	{
<<<<<<< HEAD
		// echo "--------insert works------- ";
		// remove unwanted data 
=======

		/** remove unwanted data **/
>>>>>>> 0183fd1ef18e487236a95d335512ab343555c230
		if(!empty($this->allowedColumns))
		{
			foreach ($data as $key => $value) {
				
				if(!in_array($key, $this->allowedColumns))
				{
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);

		$query = "insert into $this->table (".implode(",", $keys).") values (:".implode(",:", $keys).")";
<<<<<<< HEAD
		// echo $query;
=======

>>>>>>> 0183fd1ef18e487236a95d335512ab343555c230
		$this->query($query, $data);

		return false;
	}

	public function update($id, $data, $id_column = 'id')
	{

		var_dump($id_column);
		/** remove unwanted data **/
		if(!empty($this->allowedColumns))
		{
			// print_r($data);
			foreach ($data as $key => $value) {
				
				if(!in_array($key, $this->allowedColumns))
				{
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);
		$query = "update $this->table set ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . ", ";
		}

		$query = trim($query,", ");

		$query .= " where $id_column = :$id_column ";

		$data[$id_column] = $id;

		            // Stop execution to view the outpu

		// var_dump($query);
		$result = $this->query($query, $data);

		if ($result) {
			return true; // Return true if update was successful
		} else {
			return false; // Return false if update failed
		}

	}

	// public function delete($id, $id_column = 'id')
	// {

	// 	$data[$id_column] = $id;
	// 	$query = "delete from $this->table where $id_column = :$id_column ";
	// 	$this->query($query, $data);

	// 	return false;

	// }

	public function delete($id, $id_column = 'id')
	{
		$data[$id_column] = $id;
		$query = "DELETE FROM $this->table WHERE $id_column = :$id_column";

		$result = $this->query($query, $data); // Execute the query

		// Return true if the deletion was successful, otherwise false
		return $result ? true : false;
	}


	
}