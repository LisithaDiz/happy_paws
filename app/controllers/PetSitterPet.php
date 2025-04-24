<?php

class PetSitterPet
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

        // Get all appointments and filter for completed ones
        $allAppointments = $this->sitterAppointments->getSitterAppointments($sitter_id);
        $completedAppointments = array_filter($allAppointments, function($appointment) {
            return $appointment->appointment_status === 'done';
        });

        $this->view('petsitterpet', [
            'appointments' => $completedAppointments
        ]);
    }
}