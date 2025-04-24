<?php

class PetSitterAccepted
{
    use Controller;

    private $sitterAppointments;

    public function __construct()
    {
        $this->sitterAppointments = new SitterAppointments();
    }

    public function index()
    {
        // Get the sitter_id from session
        $sitter_id = $_SESSION['sitter_id'] ?? null;
        
        if (!$sitter_id) {
            redirect('login');
        }

        // Get all appointments and filter for confirmed ones
        $allAppointments = $this->sitterAppointments->getSitterAppointments($sitter_id);
        $acceptedAppointments = array_filter($allAppointments, function($appointment) {
            return $appointment->appointment_status == 'confirmed';
        });

        $this->view('petsitteraccepted', [
            'appointments' => $acceptedAppointments
        ]);
    }

    public function completeAppointment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_id = $_POST['appointment_id'] ?? null;

            if (!$appointment_id) {
                echo json_encode(['success' => false, 'message' => 'Missing appointment ID']);
                return;
            }

            // Update the appointment status to completed (2)
            $result = $this->sitterAppointments->updateAppointmentStatus($appointment_id, '2');

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Appointment marked as completed']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update appointment status']);
            }
        }
    }
}