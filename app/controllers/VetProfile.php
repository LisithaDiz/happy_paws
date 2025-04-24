<?php

class VetProfile
{
    use Controller;

    public function index()
    {
        // Load the Vet model
        $vetModel = new VetModel();
        $vetid = $_POST['vet_id'];


        // Fetch the first vet's details (you can modify this logic to fetch specific records later)
        $vetDetails = $vetModel->getVetDetails($vetid);
        

        // Pass the fetched data to the view
        $this->view('vetprofile', ['vetDetails' => $vetDetails]);
    }

   


    public function vetprofileUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vetUpdated = $this->updateVetDetails();
            $userUpdated = $this->updateUserDetails();
            // var_dump($vetUpdated);
            // var_dump($userUpdated);
            if ($vetUpdated && $userUpdated) {
                header("Location: " . ROOT . "/vetProfile");
                exit;
            } else {
                echo "Failed to update some details.<br>";
            }
        } else {
            echo "Failed to update some details";
        }
    }



    // public function loadView()
    // {
    //     // Load data for the profile view
    //     $vetModel = new VetModel();
    //     $userModel = new UserModel();

    //     $userid = $_SESSION['user_id'];
        

    //     // Get vet details
    //     $vetDetails = $vetModel->getById($userid, 'user_id');

    //     // Get user details
    //     $userDetails = $userModel->getById($userid, 'user_id');

    //     // Pass both vet and user data to the view
    //     require_once '../app/views/vetprofile.view.php';
    // }


    public function __construct()
    {
        //Output buffering prevents any direct output (e.g., echo, errors, warnings) 
        //from being sent to the browser immediately. Instead, all output is stored in a buffer.
        ob_start();
    }

    public function updateVetDetails()
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
                'consultation_fee' => $_POST['consultation_fee'],
                'about_us' => $_POST['about_us'],

            ];


            
            $userid = $_SESSION['user_id'];
           
            // var_dump($userid);

            $vetModel = new VetModel(); // Use VetModel which extends the core Model

            // After updating, you can redirect the user to the profile page or show a success message
            $result = $vetModel->update($userid, $data, 'user_id');
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

            // You may want to validate the data here, e.g., check if required fields are filled

            // // Get the vet's ID, for example from the session or passed as a parameter
            $userid = $_SESSION['user_id']; // Assuming the user ID is stored in the session
            // $userid = 2;
            // Load the Vet model

            $userModel = new UserModel(); // Use VetModel which extends the core Model



            // After updating, you can redirect the user to the profile page or show a success message
            
            $result = $userModel->update($userid, $data, 'user_id');
            return $result;
            
            }
            return false;
    }

    public function deleteVet()
    {
        $vetid = $_SESSION['vet_id'];
        
        // Ensure $vetid is not empty
        if (empty($vetid)) {
            echo "Vet ID is not set!";
            return;
        }
    
        // Instantiate the Vet model
        $vetModel = new VetModel();
    
        $data = ['activity_status' => 0];
    
        // Debugging: Check the query
        echo "Updating vet with ID: $vetid<br>";
    
        // Instead of deleting, update activity_status to 0
        $updateStatus = $vetModel->update($vetid, $data, 'vet_id');

    
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