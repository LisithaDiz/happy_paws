<?php

class Notification
{
    use Model;

    protected $table = 'notifications';

    public function getNotificationById($notification_id)
    {
        try {
            $query = "SELECT * FROM notifications WHERE notification_id = :notification_id LIMIT 1";
            
            // Debug log
            error_log("Executing getNotificationById query: " . $query);
            error_log("With notification_id: " . $notification_id);
            
            $result = $this->query($query, [':notification_id' => $notification_id]);
            
            // Debug log
            error_log("Query result: " . ($result ? "Found notification" : "No notification found"));
            
            return $result ? $result[0] : null;
        } catch (Exception $e) {
            error_log("Error in getNotificationById: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return null;
        }
    }

    public function markAsRead($notification_id)
    {
        try {
            // First check if notification exists
            $notification = $this->getNotificationById($notification_id);
            if (!$notification) {
                error_log("No notification found with ID: " . $notification_id);
                return false;
            }

            $query = "UPDATE notifications 
                      SET is_read = 1 
                      WHERE notification_id = :notification_id";
            
            // Debug log
            error_log("Executing markAsRead query: " . $query);
            error_log("With notification_id: " . $notification_id);
            
            $result = $this->query($query, [':notification_id' => $notification_id]);
            
            // Debug log
            error_log("markAsRead result: " . ($result ? "Success" : "Failed"));
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in markAsRead: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function getUnreadNotifications($user_id)
    {
        try {
            $query = "SELECT * FROM notifications 
                      WHERE user_id = :user_id AND is_read = 0 
                      ORDER BY created_at DESC";
            
            // Debug log
            error_log("Executing getUnreadNotifications query: " . $query);
            error_log("With user_id: " . $user_id);
            
            $result = $this->query($query, [':user_id' => $user_id]);
            
            // Debug log
            error_log("Found " . count($result) . " unread notifications");
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getUnreadNotifications: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return [];
        }
    }

    public function createNotification($data)
    {
        try {
            if (!isset($data['user_id']) || !isset($data['message'])) {
                error_log("Missing required fields for notification creation");
                return false;
            }

            $query = "INSERT INTO notifications (user_id, message, type, reference_id, created_at, is_read) 
                      VALUES (:user_id, :message, :type, :reference_id, NOW(), 0)";
            
            // Debug log
            error_log("Executing createNotification query: " . $query);
            error_log("With data: " . print_r($data, true));
            
            $params = [
                ':user_id' => $data['user_id'],
                ':message' => $data['message'],
                ':type' => $data['type'] ?? null,
                ':reference_id' => $data['reference_id'] ?? null
            ];
            
            $result = $this->query($query, $params);
            
            // Debug log
            error_log("createNotification result: " . ($result ? "Success" : "Failed"));
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in createNotification: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function getNotificationCount($user_id)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM notifications 
                      WHERE user_id = :user_id AND is_read = 0";
            
            $result = $this->query($query, [':user_id' => $user_id]);
            return $result[0]->count ?? 0;
        } catch (Exception $e) {
            error_log("Error getting notification count: " . $e->getMessage());
            return 0;
        }
    }
} 