 <?php 

spl_autoload_register(function($classname){

	$filename = "../app/models/".ucfirst($classname).".php";
	if(file_exists($filename)){
		// echo "  model loading....";
        require $filename;    
    }
	else{
		echo $filename;
		echo "----model not working (in init.php file)------";
	}
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';

// or wherever your routing is defined
$routes = [
    'reviews/add' => ['Reviews', 'add'],
    'reviews/index/{id}' => ['Reviews', 'index'],
    // ... other routes
];