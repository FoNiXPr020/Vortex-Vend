<?php

/**
 * Session - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

class Session
{
    public static function initSession() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            //ini_set('session.cookie_secure', true); // Ensure cookies are sent over HTTPS
            //ini_set('session.cookie_httponly', true);  // Prevent JavaScript access to session cookie
            //ini_set('session.cookie_samesite', 'Strict');  // Mitigate CSRF attacks
            session_start();
        }
    }

    public static function has($key)
    {
        return (bool) static::get($key);
    }

    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function remove($key)
    {
        $_SESSION[$key] = null;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function flash($key, $value)
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash()
    {
       unset($_SESSION['_flash']);
    }

    public static function flush()
    {
        $_SESSION = [];
    }

    public static function destroy()
    {
        static::flush();
        session_destroy();
        $cookieParams = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $cookieParams['path'],
            $cookieParams['domain'],
            $cookieParams['secure'],
            $cookieParams['httponly']
        );
    }
    
    public static function login($userData)
    {
        Session::put('user', $userData);
        session_regenerate_id(true); // Regenerate session ID to prevent session fixation
    }

    public static function logout()
    {
        Session::destroy();
    }
}
