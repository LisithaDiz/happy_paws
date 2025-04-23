<?php

class PharmacyProfile
{
    use Controller;

    public function index()
    {
        $pharmacyModel = new PharmacyModel;
        $pharmacyid = $_POST['pharmacy_id'];
        $pharmacyDetails = $pharmacyModel->getPharmacyDetails($pharmacyid);
        $this->view('pharmacyprofile',['pharmacyDetails'=>$pharmacyDetails]);
    }

    public function pharmacyProfileUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pharmacyUpdated = $this->updatePharmacyDetails();
            $userUpdated = $this->updateUserDetails();
            
            if ($pharmacyUpdated && $userUpdated) {
                header("Location: " . ROOT . "/pharmacyProfile");
                exit;
            } else {
                echo "Failed to update some details.<br>";
            }
        } else {
            echo "Failed to update some details.<br>";
        }
    }






    public function __construct()
    {
        //Output buffering prevents any direct output (e.g., echo, errors, warnings) 
        //from being sent to the browser immediately. Instead, all output is stored in a buffer.
        ob_start();
    }

    public function updatePharmacyDetails()
    {
    
        // Check if the form is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data from the POST request
            $data = [
                'name'      => $_POST['name'],
                'district'    => $_POST['district'],
                'city'        => $_POST['city'],
                'street'        => $_POST['street'],
                'contact_no'  => $_POST['contact_no'],
                'about_us'   => $_POST['about_us']
            ];

            
            $userid = $_SESSION['user_id'];
           
            // var_dump($userid);

            $pharmacyModel = new PharmacyModel(); 

            // After updating, you can redirect the user to the profile page or show a success message
            $result = $pharmacyModel->update($userid, $data, 'user_id');
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

            $userid = $_SESSION['user_id']; 
           
            $userModel = new UserModel(); 


            
            $result = $userModel->update($userid, $data, 'user_id');
            return $result;
            
            }
            return false;
    }

    public function deletePharmacy()
    {
        $pharmacyid = $_SESSION['pharmacy_id'];
        
        if (empty($pharmacyid)) {
            echo "pharmacy ID is not set!";
            return;
        }
    
        $pharmacyModel = new PharmacyModel();
    
        $data = ['activity_status' => 0];
    
        // Debugging: Check the query
        echo "Updating pharmacy with ID: $pharmacyid<br>";
    
        // Instead of deleting, update activity_status to 0
        $updateStatus = $pharmacyModel->update($pharmacyid, $data, 'pharmacy_id');

    
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