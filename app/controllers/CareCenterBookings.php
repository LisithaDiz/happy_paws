<?php

class CareCenterBookings
{
    use Controller;

    public function index()
    {
        $careCenterBookingModel = new CareCenterBookingModel;
        
        // Get current month's bookings
        $today = date('Y-m-d');
        $firstDayOfMonth = date('Y-m-01');
        $lastDayOfMonth = date('Y-m-t');
        
        // Get bookings based on user role
        if ($_SESSION['user_role'] == 4) { // Care Center
            $care_center_id = $_SESSION['user_id'];
            $bookingDetails = $careCenterBookingModel->getAllBookingsByCareCenter($care_center_id);
        } else { // Pet Owner
            $owner_id = $_SESSION['owner_id'];
            $bookingDetails = $careCenterBookingModel->getBookingsByPetOwner($owner_id);
        }
        
        // Ensure bookingDetails is an array
        if (!is_array($bookingDetails)) {
            $bookingDetails = [];
        }
        
        // Get cancelled bookings
        $cancelledBookingDetails = array_filter($bookingDetails, function($booking) {
            return $booking->status === 'Cancelled';
        });
        
        // Filter out cancelled bookings from main list
        $bookingDetails = array_filter($bookingDetails, function($booking) {
            return $booking->status !== 'Cancelled';
        });

        $this->view('careCenterBookings', [
            'bookingDetails' => array_values($bookingDetails),
            'cancelledBookingDetails' => array_values($cancelledBookingDetails)
        ]);
    }

    public function cancelBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking_id = $_POST['booking_id'];
            
            $model = new CareCenterBookingModel;
            $result = $model->cancelBooking($booking_id);
            
            if ($result) {
                // Update the available cages count
                $booking = $model->getBookingById($booking_id);
                if ($booking) {
                    $cageModel = new CageModel();
                    $cage = $cageModel->getCageById($booking->cage_id);
                    if ($cage) {
                        $cageModel->updateCage($booking->cage_id, ['available_cages' => $cage->available_cages + 1], 'cage_id');
                    }
                }
                
                header("Location: " . ROOT . "/careCenterBookings");
                exit;
            } else {
                echo "Error cancelling booking.";
            }
        }
    }

    public function createBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookingModel = new CareCenterBookingModel();
            $cageModel = new CageModel();
            
            // Get form data
            $cage_id = $_POST['cage_id'];
            $carecenter_id = $_POST['carecenter_id'];
            $pet_id = $_POST['pet_id'];
            $special_req = $_POST['special_req'] ?? '';
            $booking_dates_json = $_POST['booking_dates'] ?? '[]';
            
            // Decode the JSON string into an array
            $booking_dates = json_decode($booking_dates_json, true);
            
            if (!is_array($booking_dates)) {
                $_SESSION['error'] = "Invalid booking dates format";
                header("Location: " . ROOT . "/careCenterProfile");
                exit;
            }
            
            // Get current user's owner_id
            $owner_id = $_SESSION['owner_id'];
            
            // Prepare bookings array
            $bookings = [];
            foreach ($booking_dates as $date) {
                $bookings[] = [
                    'care_center_id' => $carecenter_id,
                    'pet_id' => $pet_id,
                    'owner_id' => $owner_id,
                    'cage_id' => $cage_id,
                    'booking_date' => $date,
                    'status' => 'Pending',
                    'special_req' => $special_req,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            
            // Insert bookings
            $result = $bookingModel->insertMultipleBookings($bookings);
            
            if ($result) {
                // Update available cages count
                $cage = $cageModel->getCageById($cage_id);
                if ($cage) {
                    // $new_available_count = $cage->available_cages - count($booking_dates);
                    // $cageModel->updateCage($cage_id, ['available_cages' => $new_available_count], 'cage_id');
                }
                
                // Redirect to bookings page with success message
                $_SESSION['success'] = "Booking created successfully!";
                header("Location: " . ROOT . "/petOwnerBookings");
                exit;
            } else {
                // Handle error
                $_SESSION['error'] = "Failed to create booking. Please try again.";
                header("Location: " . ROOT . "/careCenterProfile");
                exit;
            }
        }
    }
} 