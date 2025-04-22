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
        // Disable error reporting for this request
        error_reporting(0);
        ini_set('display_errors', 0);
        
        // Clear any existing output buffers and start a new one
        while (ob_get_level()) ob_end_clean();
        ob_start();
        
        // Set headers for JSON response
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        try {
            // Check if this is an AJAX request
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
                throw new Exception('Invalid request method');
            }

            // Check if user is logged in - use owner_id for pet owners
            if (!isset($_SESSION['owner_id'])) {
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

            // Check if notification belongs to the logged-in user - use owner_id
            if ($notification->user_id != $_SESSION['owner_id']) {
                throw new Exception('Unauthorized access');
            }

            // Check if already marked as read
            if ($notification->is_read) {
                ob_end_clean();
                echo json_encode(['success' => true, 'message' => 'Notification already marked as read']);
                exit();
            }

            // Mark notification as read
            if ($this->notification->markAsRead($notification_id)) {
                ob_end_clean();
                echo json_encode(['success' => true, 'message' => 'Notification marked as read']);
                exit();
            } else {
                throw new Exception('Failed to mark notification as read');
            }

        } catch (Exception $e) {
            // Log the error
            error_log("Error in markAsRead: " . $e->getMessage());
            
            // Clear any output that might have been generated
            ob_end_clean();
            
            // Set error HTTP status code
            http_response_code(400);
            
            // Return error JSON
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
            exit();
        }
    }
} 