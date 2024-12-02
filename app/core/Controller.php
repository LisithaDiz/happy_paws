<?php 


Trait Controller
{
	public function view($name, $data = [])
	{
		$filename = "../app/views/" . $name . ".view.php";
		if (file_exists($filename)) {
			extract($data);

			// to check
			// echo "file exists";

			require $filename;
		} else {
			$filename = "../app/views/404.view.php";
			require $filename;
		}
	}
	
	protected function model($model) {
		// Assuming your models are in app/models directory
		require_once '../app/models/' . $model . '.php';
		return new $model();
	}
	
	public function loadModel($modelName) {
		if (file_exists("../app/models/" . $modelName . ".php")) {
			require_once "../app/models/" . $modelName . ".php";
			return new $modelName();
		}
		return false;
	}

}
