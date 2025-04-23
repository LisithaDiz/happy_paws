<?php

class PetOwnerDash
{
    use Controller;

    public function index()
    {
        // Check if user is logged in
        if (!isset($_SESSION['owner_id'])) {
            header("Location: " . ROOT . "/login");
            exit();
        }

        // Get user's notifications
        $notification = new Notification();
        $notifications = $notification->getUnreadNotifications($_SESSION['owner_id']);

        // Get user details
        $petOwner = new PetOwnerModel();
        $user = $petOwner->first(['owner_id' => $_SESSION['owner_id']]);

        $data = [
            'notifications' => $notifications,
            'user_name' => $user ? $user->f_name : null
        ];

        $this->view('petownerdash', $data);
    }
}