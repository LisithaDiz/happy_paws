<?php 

spl_autoload_register(function($classname){


	$filename = "../app/models/".ucfirst($classname).".php";
	if(file_exists($filename)){
		echo "  model loading....";
        require $filename;    
    }
	else{
		echo $filename;
		echo "----init file not working------";
	}

});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';