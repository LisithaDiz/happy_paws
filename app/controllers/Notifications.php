<?php

require_once '../app/models/Notification.php';

class Notifications extends Controller
{
    private Notification $notification;

    public function __construct()
    {
        parent::__construct();
        $this->notification = new Notification();
    }

    public function markAsRead($notification_id = null)
    {
        // Clear any existing output buffers
        while (ob_get_level()) ob_end_clean();
        
        // Set headers for JSON response
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        try {
            // Check if this is an AJAX request
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
                throw new Exception('Invalid request method');
            }

            // Check if user is logged in
            if (!isset($_SESSION['user_id'])) {
                throw new Exception('User not authenticated');
            }

            // Validate notification ID
            if (!$notification_id || !is_numeric($notification_id)) {
                throw new Exception('Invalid notification ID');
            }

            // Get the notification
            $notification = $this->notification->getNotificationById($notification_id);
            if (!$notification) {
                throw new Exception('Notification not found');
            }

            // Check if notification belongs to the logged-in user
            if ($notification->user_id != $_SESSION['user_id']) {
                throw new Exception('Unauthorized access');
            }

            // Check if already marked as read
            if ($notification->is_read) {
                echo json_encode(['success' => true, 'message' => 'Notification already marked as read']);
                return;
            }

            // Mark notification as read
            if ($this->notification->markAsRead($notification_id)) {
                echo json_encode(['success' => true, 'message' => 'Notification marked as read']);
            } else {
                throw new Exception('Failed to mark notification as read');
            }

        } catch (Exception $e) {
            error_log("Error in markAsRead: " . $e->getMessage());
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
} 