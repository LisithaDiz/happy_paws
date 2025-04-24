<?php

class PetOwnerBookings
{
    use Controller;

    public function index()
    {
        if ($_SESSION['user_role'] !== 1) {
            redirect('users/login');
        }

        $booking = new CareCenterBookingModel();
        $bookings = $booking->getBookingsByPetOwner($_SESSION['owner_id']);
        
        $currentBookings = [];
        $pastBookings = [];
        $cancelledBookings = [];
        
        $today = date('Y-m-d');
        
        foreach ($bookings as $booking) {
            $careCenter = new CareCenterModel();
            $pet = new PetModel();
            
            $careCenterData = $careCenter->getCareCenterById($booking->care_center_id);
            $petData = $pet->getPetById($booking->pet_id);
            
            $booking->care_center_name = $careCenterData->name;
            $booking->pet_name = $petData->pet_name;
            // var_dump($bookings);
            
            if ($booking->status === 'Cancelled') {
                $cancelledBookings[] = $booking;
            } else if ($booking->end_date < $today) {
                $pastBookings[] = $booking;
            } else {
                // A booking is current if:
                // 1. It's not cancelled
                // 2. It hasn't ended yet
                // 3. It's either ongoing or upcoming
                $currentBookings[] = $booking;
            }
        }
        
        $data = [
            'currentBookings' => $currentBookings,
            'pastBookings' => $pastBookings,
            'cancelledBookings' => $cancelledBookings,
            'message' => $_SESSION['message'] ?? null,
            'message_type' => $_SESSION['message_type'] ?? null
        ];

        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        
        $this->view('petownerBookings', $data);
    }

    public function cancelBooking($bookingId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $booking = new CareCenterBookingModel();
            $bookingData = $booking->getBookingById($bookingId);
            
            if (!$bookingData || $bookingData->owner_id !== $_SESSION['owner_id']) {
                $_SESSION['message'] = 'Unauthorized action';
                $_SESSION['message_type'] = 'error';
                redirect('petownerBookings');
            }
            
            $today = date('Y-m-d');
            if ($bookingData->status === 'Cancelled' || $bookingData->end_date < $today) {
                $_SESSION['message'] = 'This booking cannot be cancelled';
                $_SESSION['message_type'] = 'error';
                redirect('petownerBookings');
            }
            
            if ($booking->cancelBooking($bookingId)) {
                $_SESSION['message'] = 'Booking cancelled successfully';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to cancel booking';
                $_SESSION['message_type'] = 'error';
            }
            
            redirect('petownerbookings');
        }
    }

    public function viewBooking($bookingId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $booking = new CareCenterBookingModel();
            $bookingData = $booking->getBookingById($bookingId);
            
            if (!$bookingData || $bookingData->pet_owner_id !== $_SESSION['user_id']) {
                $_SESSION['message'] = 'Unauthorized action';
                $_SESSION['message_type'] = 'error';
                redirect('petownerBookings');
            }
            
            $careCenter = new CareCenterModel();
            $pet = new PetModel();
            
            $careCenterData = $careCenter->getCareCenterById($bookingData->care_center_id);
            $petData = $pet->getPetById($bookingData->pet_id);
            
            $bookingData->care_center_name = $careCenterData->name;
            $bookingData->pet_name = $petData->name;
            
            $data = [
                'booking' => $bookingData,
                'message' => $_SESSION['message'] ?? null,
                'message_type' => $_SESSION['message_type'] ?? null
            ];

            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            
            $this->view('petowner_booking_details', $data);
        }
    }
} 