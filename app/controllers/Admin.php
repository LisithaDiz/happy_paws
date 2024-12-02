<?php
        

class Admin
{        

    use Controller;

    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

	public function adminLogin() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            // echo "aaaaa";
            $user = $this->adminModel->adminAuthenticate($username,$password);
            
            if (empty($user)) {
                echo "<script>
                        alert('Invalid username or password.');
                        window.location.href = '" . ROOT . "/adminlogin';
                      </script>";
                exit();
            }
            
            
            if($user){

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                

                $_SESSION['user_id'] = $user->user_id;
                $_SESSION['user_role'] = 'admin'; 
                $_SESSION['user_status'] = 1;

                redirect('adminDashboard');

            } else {
               
                echo "Invalid username or password.";
                $this->view('adminLogin');
            }

    	}

	}


    public function allMedicine()
    {
        // Fetch all medicines for display
        $medicineModel = new MedicineModel();
        $medicines = $medicineModel->getAllMedicines();

        // Pass data to the view
        include '../app/views/manageMedicine.php';
    }

    public function addMedicine()
    {   
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'med_name' => $_POST['med_name'],
                'med_description' => $_POST['med_description'],
            ];
            // print_r($data);

            $medicineModel = new MedicineModel();
            $medicineModel->insertMedicine($data);

            redirect('/manageMedicine');
        }
    }

    public function updateMedicine()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['med_id'];
            // show($id);
            $data = [
                'med_name' => $_POST['med_name'],
                'med_description' => $_POST['med_description'],
            ];

            var_dump($data);
            $medicineModel = new MedicineModel();
            $medicineModel->updateMedicine($id, $data ,$id);

            redirect('/manageMedicine');

        }
    }

    public function deleteMedicine()
    {
        echo "in admin s delete fuction";
        if (($_SERVER['REQUEST_METHOD'] === 'POST')) {
            $id = $_POST['med_id'];

            $medicineModel = new MedicineModel();
            $medicineModel->deleteMedicine($id);

            redirect('manageMedicine');
        }
    }
}


