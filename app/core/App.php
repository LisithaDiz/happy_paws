<?php


class App
{
    private $controller = 'Home';
    private $method     = 'index';

    private $roleAccess = [
        // 'admin' => [
        //     // 'AdminTasks' => ['index', 'manageUsers', 'viewReports'], 
        //     // 'AdminProfile' => ['index'],
        // ],
        '1' => ['PetOwnerDashboard' => ['index']],
        '2' => ['VetDashboard' => ['index']],
        '3' => ['PetSitterDashboard' => ['index']],
        '4' => ['CareCenterDashboard' => ['index']],
        '5' => ['PharmacyDashboard' => ['index']],
        
    ];

    private $publicAccess = [
        'Home' => ['index'],
        '-404' => ['index'],
        'About' => ['index'],
        'Signup_role' => ['index'],
        'Signup' => ['index'],
        'Login' => ['index'],
        'User' => ['login', 'signupProcess'],
    ];

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        return explode("/", trim($URL, "/"));
    }

    private function checkAccess($controller, $method)
    {
        //checking
        // echo $_SESSION['user_role'] ; 
        // echo   $_SESSION['user_status']; 
        if (isset($_SESSION['user_role'], $_SESSION['user_status']) && $_SESSION['user_status'] == '1') {
            $role =(string) $_SESSION['user_role'];
            
            // for debugging
            // var_dump($_SESSION['user_role'], $_SESSION['user_status']);
            // var_dump($role, $controller, $method);
            
            return true;
        }
        return false;
    }

    private function isPublic($controller, $method)
    {
        return isset($this->publicAccess[$controller]) && in_array($method, $this->publicAccess[$controller]);
    }

    public function loadController()
    {
        $URL = $this->splitURL();

        /** Select controller **/
        $filename = "../app/controllers/" . ucfirst($URL[0]) . ".php";
        if (file_exists($filename)) {
            require $filename;
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        } else {
            // Load 404 controller for invalid URLs
            require "../app/controllers/_404.php";
            $this->controller = "_404";
        }

        $controller = new $this->controller;

        /** Select method **/
        if (!empty($URL[1])) {
            if (method_exists($controller, $URL[1])) {
                $this->method = $URL[1];
                unset($URL[1]);
            }
        }

        /** Check Access **/
        if ($this->isPublic($this->controller, $this->method) || $this->checkAccess($this->controller, $this->method)) {
            call_user_func_array([$controller, $this->method], $URL);
        } else {
            echo "   Error...controller not loading (in app)";
            // Redirect to unauthorized access page or show an error
            // header("Location: /unauthorized");
            exit();
        }
    }
}

// class App
// {
// 	private $controller = 'Home';
// 	private $method 	= 'index';

// 	private function splitURL()
// 	{
// 		$URL = $_GET['url'] ?? 'home';
// 		$URL = explode("/", trim($URL,"/"));
// 		return $URL;	
// 	}

// 	public function loadController()
// 	{
// 		$URL = $this->splitURL();

// 		/** select controller **/
// 		$filename = "../app/controllers/".ucfirst($URL[0]).".php";
// 		// echo "$URL[0]";//checking
// 		if(file_exists($filename))
// 		{
// 			require $filename;
// 			$this->controller = ucfirst($URL[0]);
// 			unset($URL[0]);
// 		}else{

// 			$filename = "../app/controllers/_404.php";
// 			require $filename;
// 			$this->controller = "_404";
// 		}

// 		$controller = new $this->controller;

// 		/** select method **/
// 		if(!empty($URL[1]))
// 		{
// 			if(method_exists($controller, $URL[1]))
// 			{
// 				$this->method = $URL[1];
// 				unset($URL[1]);
// 			}	
// 		}

// 		call_user_func_array([$controller,$this->method], $URL);

// 	}	

// }


