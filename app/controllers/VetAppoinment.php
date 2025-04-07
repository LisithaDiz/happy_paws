<?php

class VetAppoinment
{
    use Controller;

    public function index()
    {
        $vetAppointmentModel = new vetAppointmentModel;

        $appointmentDetails = $vetAppointmentModel->getAppointmentDetails();

        $this->view('VetAppoinment', ['appointmentDetails' => $appointmentDetails]);
    }

    // public function appointmentStatus()
    // {
    //     $vetModel = new vetModel;
        
    //     $vetModel->updateAppointmentStatus();
    //     echo"hpppp";

    // }

    public function appointmentStatus()
    {
    
        $appointmentid = $_POST['appointment_id'];
        var_dump($appointmentid);
        // Check if the form is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data from the POST request
            $data = [
                'appointment_status'      => '1',    
            ];



            // You may want to validate the data here, e.g., check if required fields are filled

            // // Get the vet's ID, for example from the session or passed as a parameter
            // $id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
            // $vetid = 1;
            // Load the Vet model
            $userid = $_SESSION['user_id'];
           
            // var_dump($userid);

            $vetAppointmentModel = new VetAppointmentModel(); // Use VetModel which extends the core Model
         
            // After updating, you can redirect the user to the profile page or show a success message
            $result = $vetAppointmentModel->update($appointmentid, $data, 'appointment_id');
            
         

            return $result;
            if ($result)
            {
                header("Location: " . ROOT . "/vetAppoinment"); // Replace with your target URL
                exit;
            }
            else{
                return false;
            }
            
            
            
            }
            return false;

    }
}
