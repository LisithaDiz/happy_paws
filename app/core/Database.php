<?php 

Trait Database
{
	protected function connect()
	{
		try {
			$string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
			$con = new PDO($string,DBUSER,DBPASS);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $con;
		} catch (PDOException $e) {
			error_log("Database connection error: " . $e->getMessage());
			return null;
		}
	}

	public function query($query, $data = [])
	{
		$con = $this->connect();
		if ($con === null) {
			return false;
		}

		$stm = $con->prepare($query);
		$check = $stm->execute($data);
		if ($check) {
			$result = $stm->fetchAll(PDO::FETCH_OBJ);
			return (is_array($result) && count($result)) ? $result : true;
		} else {
			return false;
		}
	}

	public function get_row($query, $data = [])
	{
		$con = $this->connect();
		if ($con === null) {
			return false;
		}

		$stm = $con->prepare($query);
		$check = $stm->execute($data);
		if ($check) {
			$result = $stm->fetchAll(PDO::FETCH_OBJ);
			return (is_array($result) && count($result)) ? $result[0] : false;
		}

		return false;
	}
}
