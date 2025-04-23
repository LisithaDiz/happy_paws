<?php

class PetSitterProfile
{
    use Controller;

    public function index()
    {
        $sitterModel = new PetSitterModel;
        $sitterid = $_POST['sitter_id'];
        $sitterDetails = $sitterModel->getSitterDetails($sitterid);
        
        $this->view('petsitterprofile',['sitterDetails'=>$sitterDetails]);
    }

    public function sitterProfileUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sitterUpdated = $this->updatesitterDetails();
            $userUpdated = $this->updateUserDetails();
            
            if ($sitterUpdated && $userUpdated) {
                header("Location: " . ROOT . "/PetSitterProfile");
                exit;
            } else {
                echo "Failed to update some details.<br>";
            }
        } else {
            $this->loadView();
        }
    }



    public function loadView()
    {
        // Load data for the profile view
        $sitterModel = new PetSitterModel();
        $userModel = new UserModel();

        $userid = $_SESSION['user_id'];
        

        // Get vet details
        $sitterDetails = $sitterModel->getById($userid, 'user_id');

        // Get user details
        $userDetails = $userModel->getById($userid, 'user_id');

        // Pass both vet and user data to the view
        require_once '../app/views/PetSitterprofile.view.php';
    }


    public function __construct()
    {
        //Output buffering prevents any direct output (e.g., echo, errors, warnings) 
        //from being sent to the browser immediately. Instead, all output is stored in a buffer.
        ob_start();
    }

    public function updateSitterDetails()
    {
    
        // Check if the form is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data from the POST request
            $data = [
                'f_name'      => $_POST['f_name'],
                'l_name'      => $_POST['l_name'],
                'age'         => $_POST['age'],
                'gender'      => $_POST['gender'],
                'district'    => $_POST['district'],
                'city'        => $_POST['city'],
                'contact_no'  => $_POST['contact_no'],
                'years_exp'   => $_POST['years_exp'],
                'about_us'    => $_POST['about_us']
            ];

            
            $userid = $_SESSION['user_id'];
           
            

            $sitterModel = new PetSitterModel(); // Use VetModel which extends the core Model

            // After updating, you can redirect the user to the profile page or show a success message
            $result = $sitterModel->update($userid, $data, 'user_id');
            // var_dump($result);
            

            return $result;
            
            
            }
            return false;

    }

    public function updateUserDetails()
    {
        
        // Check if the form is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data from the POST request
            $data = [
                'username'      => trim($_POST['username']),
                
            ];

            
            $userid = $_SESSION['user_id']; // Assuming the user ID is stored in the session
           

            $userModel = new UserModel(); // Use VetModel which extends the core Model



            // After updating, you can redirect the user to the profile page or show a success message
            
            $result = $userModel->update($userid, $data, 'user_id');
            return $result;
            
            }
            return false;
    }

    public function deleteSitter()
    {
        $sitterid = $_SESSION['sitter_id'];
        
        // Ensure $vetid is not empty
        if (empty($sitterid)) {
            echo "Vet ID is not set!";
            return;
        }
    
        // Instantiate the Vet model
        $sitterModel = new PetSitterModel();
    
        $data = ['activity_status' => 0];
    
        
    
        // Instead of deleting, update activity_status to 0
        $updateStatus = $sitterModel->update($sitterid, $data, 'sitter_id');
        
    
        if ($updateStatus) {
            echo "Profile deactivated successfully.";
            // Redirect after deactivation
            header("Location: " . ROOT . "/home");
            exit();
        } else {
            echo "Failed to deactivate profile.";
        }
    }
}