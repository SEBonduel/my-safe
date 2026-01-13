<?php

namespace App\Utils;

class Security
{
    public static function safeSessionStart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            session_start();
        }
    }

     public static function getCsrfToken(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function login($userId)
    {
        self::safeSessionStart();

        session_regenerate_id(true);

        $_SESSION['user_id'] = $userId;
    }

    public static function isLogged()
    {
        self::safeSessionStart();

        return isset($_SESSION['user_id']);
    }

    public static function logout()
    {
        self::safeSessionStart();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'] ?? '',
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
}
