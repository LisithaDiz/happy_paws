<?php

class PetOwnerProfile
{
    use Controller;

    public function index()
    {
        $petownermodel = new PetOwnerModel;
        $owner_id = $_POST['owner_id'];
        $ownerModel = new PetOwnerModel;
        $ownerDetails = $ownerModel->getPetOwnerDetails($owner_id);
        
        $petModel = new Pet();
        $petDetails = $petModel->getpetDetails($owner_id);
        $this->view('petownerprofile',['ownerDetails'=>$ownerDetails,'petDetails'=>$petDetails]);
    }

    public function ownerprofileUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ownerUpdated = $this->updateOwnerDetails();
            $userUpdated = $this->updateUserDetails();
            
            if ($ownerUpdated && $userUpdated) {
                header("Location: " . ROOT . "/petownerProfile");
                exit;
            } else {
                echo "Failed to update some details.<br>";
            }
        } else {
            echo "Failed to update some details";
        }
    }

    public function updateOwnerDetails()
    {
    
        // Check if the form is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data from the POST request
            $data = [
                'f_name'      => $_POST['f_name'],
                'l_name'      => $_POST['l_name'],
                'age'         => $_POST['age'],
                'district'    => $_POST['district'],
                'city'        => $_POST['city'],
                'contact_no'  => $_POST['contact_no']

            ];


            
            $userid = $_SESSION['user_id'];
           
            // var_dump($userid);

            $ownerModel = new PetOwnerModel(); 

            // After updating, you can redirect the user to the profile page or show a success message
            $result = $ownerModel->update($userid, $data, 'user_id');
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

    public function deleteOwner()
    {
        $ownerid = $_SESSION['owner_id'];
        
        if (empty($ownerid)) {
            echo "Owner ID is not set!";
            return;
        }
    
        $ownerModel = new PetOwnerModel;
    
        $data = ['activity_status' => 0];
    
        
    
        // Instead of deleting, update activity_status to 0
        $updateStatus = $ownerModel->update($ownerid, $data, 'owner_id');

    
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
