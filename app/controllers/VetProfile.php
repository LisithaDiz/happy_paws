<?php

class VetProfile
{
    use Controller;

    public function index()
    {
        // Load the Vet model
        $vetModel = new Vet();

        // Fetch the first vet's details (you can modify this logic to fetch specific records later)
        $vetDetails = $vetModel->getFirstVetDetails();
        // Pass the fetched data to the view
        $this->view('vetprofile', ['vetDetails' => $vetDetails]);
    }

    public function vetprofile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->updateVetDetails(); // Call update logic for POST request
        } else {
            $this->loadView(); // Load the profile view for GET request
        }
    }

    public function loadView()
    {
        // Load data for the profile view
        $vetModel = new Vet();
        $vetid = 1; // Replace with dynamic user ID
        $vet = $vetModel->getById($vetid, 'vet_id'); // Example method to get vet details

        // Pass $vet data to the view
        require_once '../app/views/vetprofile.view.php';
    }

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
                'years_exp'   => $_POST['years_exp']
            ];

            // You may want to validate the data here, e.g., check if required fields are filled

            // // Get the vet's ID, for example from the session or passed as a parameter
            // $id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
            $vetid = 1;
            // Load the Vet model
            $vetModel = new Vet(); // Use VetModel which extends the core Model


            // After updating, you can redirect the user to the profile page or show a success message
            
            $result = $vetModel->update($vetid, $data, 'vet_id');

            if ($result) {
                // Redirect after a successful update
                header("Location: " . ROOT . "/vetprofile");
                exit;
            } else {
                echo "Failed to update vet details .";
            }
            }
    }

    public function updateUserDetails()
    {
        // Check if the form is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data from the POST request
            $data = [
                'username'      => $_POST['username'],
                
            ];

            // You may want to validate the data here, e.g., check if required fields are filled

            // // Get the vet's ID, for example from the session or passed as a parameter
            // $id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
            $userid = 2;
            // Load the Vet model
            $vetModel = new User(); // Use VetModel which extends the core Model


            // After updating, you can redirect the user to the profile page or show a success message
            
            $result = $vetModel->update($userid, $data, 'user_id');

            if ($result) {
                // Redirect after a successful update
                header("Location: " . ROOT . "/vetprofile");
                exit;
            } else {
                echo "Failed to update user details.";
            }
            }
    }


}
