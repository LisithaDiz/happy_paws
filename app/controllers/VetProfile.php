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

    public function update()
    {
        // Check if the form is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data from the POST request
            $data = [
                'username'    => $_POST['username'],
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
            $userid = 2;
            // Load the Vet model
            $vetModel = new Vet(); // Use VetModel which extends the core Model

            // Call the update method from the VetModel
            $vetModel->update($userid, $data, 'vet_id');

            // After updating, you can redirect the user to the profile page or show a success message
            header("Location: " . ROOT . "/vetprofile");
            exit;
        }
    }
}




