<?php

class PetOwner_Appointments
{
    use Controller;

    public function index()
    {
        $appointmentModel = new VetAppointmentModel;
        $appointmentDetails = $appointmentModel->appointmentDetailsOwnerView();

        $cancelledAppointments = $appointmentModel->cancelledAppoinmentsOwnerView();

        $recheduleAppointments = $appointmentModel->rescheduleAppointmentOwnerView();
        
        $this->view('petowner_appointments',['appointmentDetails'=>$appointmentDetails,'cancelledAppointments'=>$cancelledAppointments,'rescheduleAppontments'=>$recheduleAppointments]);
    }

    public function cancelAppointment($appointment_id)
    {
        $appointmentModel = new VetAppointmentModel;

        if (!empty($appointment_id) && is_numeric($appointment_id)) {
        $result = $appointmentModel->cancelAppointmentUpdate($appointment_id);
        if($result)
        {
            header("Location: " . ROOT . "/PetOwner_Appointments");
            exit;
        }
        else{
            echo "Something went wrong. Appointment could not be cancelled.";
        }

        }
        else{
            echo"Invalid Appointment ID";
        }
       

    }

    
}