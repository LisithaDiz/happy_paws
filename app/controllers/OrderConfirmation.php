<?php

class OrderConfirmation
{
    use Controller;

    public function index($order_id = null)
    {
        // Check if user is logged in
        if (!isset($_SESSION['owner_id'])) {
            header("Location: " . ROOT . "/login");
            exit();
        }

        if (!$order_id) {
            header("Location: " . ROOT . "/PetOwnerDash");
            exit();
        }

        try {
            // Get order details
            $order = new Order();
            $orderDetails = $order->getOrderById($order_id);

            // Verify the order belongs to the logged-in user
            if (!$orderDetails || $orderDetails->owner_id != $_SESSION['owner_id']) {
                $_SESSION['error'] = "Order not found or access denied";
                header("Location: " . ROOT . "/PetOwnerDash");
                exit();
            }

            // Get pharmacy details
            $pharmacy = new PharmacyModel();
            $pharmacyDetails = $pharmacy->getPharmacyById($orderDetails->pharmacy_id);

            // Get pet details
            $pet = new Pet();
            $petDetails = $pet->getPetById($orderDetails->pet_id);

            // Prepare data for the view
            $data = [
                'order' => $orderDetails,
                'pharmacy' => $pharmacyDetails,
                'pet' => $petDetails,
                'success_message' => $_SESSION['success'] ?? null
            ];

            // Clear the success message from session
            if (isset($_SESSION['success'])) {
                unset($_SESSION['success']);
            }

            $this->view('orderconfirmation', $data);

        } catch (Exception $e) {
            error_log("Error in OrderConfirmation::index: " . $e->getMessage());
            $_SESSION['error'] = "Error retrieving order details";
            header("Location: " . ROOT . "/PetOwnerDash");
            exit();
        }
    }
} 