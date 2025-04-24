<?php


class Prescription
{
    use Controller;

    public function view($prescription_id)
    {
        if (!isset($_SESSION['owner_id']) && !isset($_SESSION['pharmacy_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Please log in to view prescription']);
            exit;
        }

        $prescription = new PrescriptionModel();
        $result = $prescription->getPrescriptionDetailsForm($prescription_id);

        if (!$result) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Prescription not found']);
            exit;
        }

        // Check if the prescription belongs to the logged-in user or if it's a pharmacy viewing it
        if (isset($_SESSION['owner_id']) && $result->owner_id != $_SESSION['owner_id']) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'You do not have permission to view this prescription']);
            exit;
        }

        // If it's an AJAX request, return JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'prescription' => $result,
                'medicines' => $prescription->getPrescriptionMedicines($prescription_id)
            ]);
            exit;
        }

        // If it's a regular request, show the full view
        $data = [
            'prescription' => $result,
            'medicines' => $prescription->getPrescriptionMedicines($prescription_id)
        ];

        $this->view('prescription_details', $data);
    }
} 