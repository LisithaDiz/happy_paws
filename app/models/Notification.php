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

    public function getNotifications($user_id, $limit = 5)
    {
        try {
            $query = "SELECT * FROM notifications 
                      WHERE user_id = :user_id 
                      ORDER BY created_at DESC 
                      LIMIT :limit";
            
            $db = $this->connect();
            $stmt = $db->prepare($query);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $notifications = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            // Add time_ago property to each notification
            foreach ($notifications as $notification) {
                $notification->time_ago = $this->getTimeAgo($notification->created_at);
            }
            
            return $notifications;
        } catch (Exception $e) {
            error_log("Error in getNotifications: " . $e->getMessage());
            return [];
        }
    }

    private function getTimeAgo($datetime)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $days = $diff->days;
        $hours = $diff->h;
        $minutes = $diff->i;
        $seconds = $diff->s;

        if ($days > 0) {
            if ($days >= 7) {
                $weeks = floor($days / 7);
                return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
            }
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } elseif ($hours > 0) {
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($minutes > 0) {
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
        } else {
            return $seconds . ' second' . ($seconds > 1 ? 's' : '') . ' ago';
        }
    }
} 