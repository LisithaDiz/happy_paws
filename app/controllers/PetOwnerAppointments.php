<?php

class PetOwnerAppointments
{
    use Controller;
    private $appointmentModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }
        $this->appointmentModel = $this->model('SitterAppointments');
    }

    public function index()
    {
        $user_id = $_SESSION['user_id'];
        $appointments = $this->appointmentModel->getUserAppointments($user_id);
        
        $data = [
            'appointments' => $appointments
        ];

        $this->view('petownerappointments', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $appointment = $this->appointmentModel->getAppointmentById($id);
    
            if ($appointment && $appointment->user_id == $_SESSION['user_id']) {
                $this->appointmentModel->deleteAppointment($id);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
    
}
