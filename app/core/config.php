<?php 

if($_SERVER['SERVER_NAME'] == 'localhost')
{
	/** database config **/
  define('DBNAME', 'happy_pawsdb');

	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://localhost/final/public');

}else
{
	/** database config **/
	define('DBNAME', 'happy_pawsdb');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.yourwebsite.com');

}

define('ROOT_PATH', dirname(__DIR__));

define('ROOT_PATH', dirname(__DIR__));

define('APP_NAME', "My Webiste");
define('APP_DESC', "Best website on the planet");

/** true means show errors **/
define('DEBUG', true);
