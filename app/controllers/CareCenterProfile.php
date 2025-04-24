<?php

class CareCenterProfile
{
    use Controller;

    public function index()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('login');
            return;
        }

        // Check if user has proper role (4 for care center staff)
        if ($_SESSION['user_role'] != 4) {
            // If not care center staff, check if they're a pet owner
            if (!isset($_SESSION['owner_id'])) {
                redirect('home');
                return;
            }
        }

        if (isset($_SESSION['owner_id'])) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo "<script>
                        alert('Something went wrong!');
                        window.location.href = 'PetcareSearch';
                      </script>";
                exit();
            }
            $center_id = $_POST["id"];
        } else if (isset($_SESSION['care_center_id'])) {
            $center_id = $_SESSION['care_center_id'];
        } else {
            die('Error: Care center ID not found in session.');
        }

        // Get Care Center Info
        $careCenterModel = new CareCenterModel();
        $care_center = $careCenterModel->getCareCenterInfo($center_id);

        // Get All Cages
        $cageModel = new CageModel();
        $cages = $cageModel->getAllCages($center_id);

        // Only get pets if user is a pet owner
        $pets = [];
        if (isset($_SESSION['owner_id'])) {
            $pets = new Pet();
            $pets = $pets->findAllByOwnerId($_SESSION['owner_id']);
        }

        $data = [
            'pets' => $pets,
            'cages' => $cages,
            'petCareCenter' => $care_center
        ];
        // var_dump($data);

        $this->view('carecenterprofile', $data);
    }

    public function updateProfile() {
        if ($_SESSION['user_role'] != 4) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $careCenterModel = new CareCenterModel();
        $center_id = $_POST['care_center_id'];

        // Remove care_center_id from POST data as it's not needed in the update
        unset($_POST['care_center_id']);

        $result = $careCenterModel->updateProfile($_POST, $center_id);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
        }
    }
    
    public function getCageAvailability() {
        if (!isset($_POST['cage_id']) || !isset($_POST['care_center_id'])) {
            echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
            return;
        }
        
        $cage_id = $_POST['cage_id'];
        $care_center_id = $_POST['care_center_id'];
        
        // Get the cage details
        $cageModel = new CageModel();
        $cage = $cageModel->getCageById($cage_id);
        
        if (!$cage) {
            echo json_encode(['success' => false, 'message' => 'Cage not found']);
            return;
        }
        
        // Get all bookings for this cage
        $bookingModel = new CareCenterBookingModel();
        
        // Get current date and date 3 months from now
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime('+3 months'));
        
        $bookings = $bookingModel->getBookingsByDateRange($care_center_id, $cage_id, $start_date, $end_date);

        
        // Filter bookings for this specific cage
        $cageBookings = array_filter($bookings, function($booking) use ($cage_id) {
            return $booking->cage_id == $cage_id && $booking->status != 'Cancelled';
        });
        
        // Create an array of all dates in the range
        $allDates = [];
        $currentDate = new DateTime($start_date);
        $endDateTime = new DateTime($end_date);
        
        while ($currentDate <= $endDateTime) {
            $dateStr = $currentDate->format('Y-m-d');
            $allDates[$dateStr] = [
                'date' => $dateStr,
                'available' => true,
                'bookings' => []
            ];
            $currentDate->modify('+1 day');
        }
        
        // Mark dates as unavailable based on bookings
        foreach ($cageBookings as $booking) {
            $dateStr = date('Y-m-d', strtotime($booking->booking_date));
            if (isset($allDates[$dateStr])) {
                $allDates[$dateStr]['available'] = false;
                $allDates[$dateStr]['bookings'][] = [
                    'pet_name' => $booking->pet_name,
                    'owner_name' => $booking->owner_name
                ];
            }
        }
        
        // After marking booked dates, also mark any center-unavailable dates
        $availabilityModel = new CareCenterAvailabilityModel();
        $centerUnavailableDates = $availabilityModel->getUnavailableDates($care_center_id);
        foreach ($centerUnavailableDates as $unavailDate) {
            if (isset($allDates[$unavailDate])) {
                $allDates[$unavailDate]['available'] = false;
                $allDates[$unavailDate]['bookings'][] = [
                    'reason' => 'Center Unavailable'
                ];
            }
        }
        
        echo json_encode([
            'success' => true,
            'dates' => array_values($allDates),
            'total_cages' => $cage->number_of_cages,
            'available_cages' => $cage->available_cages
        ]);
    }
}
