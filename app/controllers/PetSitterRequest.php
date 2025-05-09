<?php

class PetSitterRequest
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

        // Get all appointments and filter for pending ones
        $allAppointments = $this->sitterAppointments->getSitterAppointments($sitter_id);
        $pendingAppointments = array_filter($allAppointments, function($appointment) {
            return $appointment->appointment_status === 'pending';
        });

        $this->view('petsitterrequest', [
            'appointments' => $pendingAppointments
        ]);
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_id = $_POST['appointment_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if (!$appointment_id || !$status) {
                echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
                return;
            }

            // Update the appointment status
            $result = $this->sitterAppointments->updateAppointmentStatus($appointment_id, $status);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Appointment status updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update appointment status']);
            }
        }
    }
}