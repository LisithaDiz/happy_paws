<?php

class Auth
{
    public static function logged_in()
    {
        return isset($_SESSION['user_id']);
    }

    public static function getUserType()
    {
        return $_SESSION['user_type'] ?? null;
    }

    public static function getUserId()
    {
        return $_SESSION['user_id'] ?? null;
    }
} 