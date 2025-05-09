<?php

class CareCenterProfile
{
    use Controller;

    public function index()
    {
        // Ensure session has center ID
        if (!isset($_SESSION['care_center_id'])) {
            die('Error: Care center ID not found in session.');
        }

        $center_id = $_SESSION['care_center_id'];

        // Get Care Center Info
        $careCenterController = new CareCenterModel();
        $care_center = $careCenterController->getCareCenterInfo($center_id);
        // var_dump($care_center);

        // Get All Cages
        $manageCageController = new CageModel();
        $cage = $manageCageController->getAllCages($center_id);
        // var_dump($cage);

        $data = [
            'cages' => $cage,
            'care_center' => $care_center
        ];

        $this->view('carecenterprofile', $data);
    }
    }
