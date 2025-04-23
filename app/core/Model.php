<?php 

/**
 * Main Model trait
 */
Trait Model
{
	use Database;

	protected $limit 		= 10;
	protected $offset 		= 0;
	protected $order_type 	= "desc";

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
		
		if($result)
			return $result[0];
		else
			return false;
	}

	public function insert($data)
	{

		/** remove unwanted data **/
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

		return $this->query($query, $data);
	}

	public function update($id, $data, $id_column = 'review_id')
	{
		
		/** remove unwanted data **/
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
		$query = "update $this->table set ";

		foreach ($keys as $key) {
			$query .= $key . " = :". $key . ", ";
		}

		$query = trim($query,", ");

		$query .= " where $id_column = :$id_column ";

		$data[$id_column] = $id;

		// var_dump($query);
		// var_dump($data);

		            // Stop execution to view the output
		
		$result = $this->query($query, $data);
		// var_dump($result);
		

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

	public function delete($id, $id_column = 'review_id')
	{
		$data[$id_column] = $id;
		$query = "DELETE FROM $this->table WHERE $id_column = :$id_column";

		$result = $this->query($query, $data); // Execute the query

		// Return true if the deletion was successful, otherwise false
		return $result ? true : false;
	}

	public function query_($query, $params = [])
	{
		try {
			$stmt = $this->connect()->prepare($query);
			
			if (!$stmt) {
				error_log("Database prepare failed for query: " . $query);
				error_log("Error info: " . print_r($this->connect()->errorInfo(), true));
				return [];
			}

			error_log("Executing query: " . $query);
			error_log("With parameters: " . print_r($params, true));
			
			$check = $stmt->execute($params);
			if (!$check) {
				error_log("Query execution failed: " . print_r($stmt->errorInfo(), true));
				return [];
			}

			// For SELECT queries
			if (stripos($query, 'SELECT') === 0) {
				$result = $stmt->fetchAll(PDO::FETCH_OBJ);
				if ($result === false) {
					error_log("Fetch failed: " . print_r($stmt->errorInfo(), true));
					return [];
				}
				return $result;
			}
			
			// For INSERT, UPDATE, DELETE queries
			return $stmt->rowCount() > 0;
		} catch (PDOException $e) {
			error_log("Database error: " . $e->getMessage());
			error_log("Query: " . $query);
			error_log("Parameters: " . print_r($params, true));
			return [];
		}
	}

	public function lastInsertId()
	{
		return $this->connect()->lastInsertId();
	}

	
	// Add new query method for notifications and other new features
	public function query($query, $params = [])
	{
		try {
			$stmt = $this->connect()->prepare($query);
			
			if (!$stmt) {
				error_log("Database prepare failed for query: " . $query);
				error_log("Error info: " . print_r($this->connect()->errorInfo(), true));
				return false;
			}

			error_log("Executing query: " . $query);
			error_log("With parameters: " . print_r($params, true));
			
			$check = $stmt->execute($params);
			if (!$check) {
				error_log("Query execution failed: " . print_r($stmt->errorInfo(), true));
				return false;
			}

			if (stripos($query, 'SELECT') === 0) {
				$result = $stmt->fetchAll(PDO::FETCH_OBJ);
				if ($result === false) {
					error_log("Fetch failed: " . print_r($stmt->errorInfo(), true));
					return [];
				}
				return $result;
			}
			
			// For INSERT, UPDATE, DELETE queries
			return $stmt->rowCount() >= 0; // Changed to >= 0 because some valid updates might affect 0 rows
		} catch (PDOException $e) {
			error_log("Database error: " . $e->getMessage());
			error_log("Query: " . $query);
			error_log("Parameters: " . print_r($params, true));
			return false;
		}
	}

}