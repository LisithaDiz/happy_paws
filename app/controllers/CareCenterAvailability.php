<?php

class CareCenterAvailability
{
    use Controller;

    public function index()
    {
        $care_center_id = $_SESSION['care_center_id'];
        $availabilityModel = new CareCenterAvailabilityModel();
        $unavailableDates = $availabilityModel->getUnavailableDates($care_center_id);
        
        $this->view('carecenteravailability', ['unavailableDates' => $unavailableDates]);
    }

    public function updateAvailability()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $care_center_id = $_SESSION['care_center_id'];
            $date = $data['date'];
            $isUnavailable = $data['isUnavailable'];

            $availabilityModel = new CareCenterAvailabilityModel();

            if ($isUnavailable) {
                $insertData = [
                    'care_center_id' => $care_center_id,
                    'unavailable_date' => $date,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $availabilityModel->insertUnavailableDate($insertData);
            } else {
                $availabilityModel->deleteUnavailableDate($date, $care_center_id);
            }

            echo json_encode(['success' => true]);
        }
    }
}