<?php

class PetOwnerBookVet 
{
    use Controller;

    public function index()
    {
        
        $vetAvailability = new VetUpdateAvailableHoursModel;

        $vet_id = $_POST['vet_id'];
        var_dump($vet_id);
        $vetAvailabilityDetails = $vetAvailability->vetAvailabilityOwnerView($vet_id);
        $this->view('petownerbookvet', ['vetAvailabilityDetails'=> $vetAvailabilityDetails]);
    }

    public function bookvet()
    {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vet_id = $_POST['vet_id'] ;
            $avl_id = $_POST['avl_id'] ;
            $date = $_POST['date'];
            $exact_time = $_POST['exact_time'];
            $owner_id = $_SESSION['owner_id'];
            $model = new VetUpdateAvailableHoursModel; // or AvailabilityModel
            $appointmentmodel = new VetAppointmentModel;

            // Get current slots first
            $current = $model->first(['avl_id' => $avl_id]);
            $data = [
                'vet_id'            => $vet_id,
                'owner_id'          => $owner_id,
                'avl_id'            => $avl_id,
                'appointment_date'  => $date,
                'appointment_time'  => $exact_time
            ];
        

            if ($current && $current->available_slots > 0) {
                // $data = [
                //     'booked_slots'    => $current->booked_slots + 1,
                //     'available_slots' => $current->available_slots - 1
                // ];
                
                // Now both fields are passed
                $model->updateAvailableSlots($avl_id);
                
                $result=$appointmentmodel->insert($data);
                
                
            }

            // if ($result) {
            //     $usermodel = new UserModel;
            //     $vetmodel = new VetModel;
            
            //     $owner = $usermodel->getOwnerById($owner_id);
            //     $vet = $vetmodel->getVetById($vet_id);
            
            //     if ($owner && $vet) {
            //         $subject = "Your Appointment is Confirmed!";
            
            //         $message = "
            //             <h2>Appointment Details</h2>
            //             <p>Hi {$owner->first_name},</p>
            //             <p>Your appointment has been successfully booked with <strong>Dr. {$vet->f_name} {$vet->l_name}</strong>.</p>
            //             <p><strong>Date:</strong> {$date}</p>
            //             <p><strong>Time:</strong> {$exact_time}</p>
            //             <p>Thank you for using Happy Paws!</p>
            //         ";
            
            //         MailHelper::sendAppointmentEmail($owner->email, $subject, $message);
            //     }
            
            //     header("Location: " . ROOT . "/paymentForm");
            //     exit;
            // }
            //create this indise MailHelper.php
            // public static function sendAppointmentEmail($toEmail, $subject, $message) {
            //     $headers = "From: noreply@yourdomain.com\r\n";
            //     $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            
            //     return mail($toEmail, $subject, $message, $headers);
            // }
            
            

            if ($result) {
                // Redirect to the payment form with the necessary data (e.g., avl_id, vet_id)
                header("Location: " . ROOT . "/paymentForm");
                exit; // Ensure no further code is executed after redirect
            } else {
                // Handle the case where the update failed (e.g., show an error message)
                echo "Error updating availability.";
            }
        }
    }
}