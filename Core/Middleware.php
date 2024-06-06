<?php

/**
 * Middleware - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

class Middleware
{
    // C
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Authenticated::class,
        'admin' => Admin::class,
        'owner' => Owner::class,
        'check_verified' => CheckVerified::class,
        'host' => Host::class
    ];

    public static function resolve($key)
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new \Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}

class Guest
{
    public function handle()
    {
        // If user is not authenticated, continue
        if (!isset($_SESSION['user'])) {
            return;
        }

        header('Location: /dashboard');
        exit();
    }
}

class Authenticated
{
    public function handle()
    {
        // If user is authenticated, continue
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            exit();
        }

        Auth::AuthJWT();
    }
}

class CheckVerified
{
    public function handle()
    {
        // If user is authenticated as verified account, continue
        if (isset($_SESSION['user']) && $_SESSION['user']['verified'] != 0) {
            header('Location: /dashboard');
            exit();
        }

        Auth::AuthJWT();
    }
}

class Admin
{
    protected $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function handle()
    {
        // If user is authenticated as admin, continue
        $userID = $_SESSION['user']['user_id'];

        // Check if user is an admin
        $access = $this->database->Query("SELECT role FROM users WHERE id = ?", [$userID])[0] ?? 'guest';

        //Functions::dd($access);

        if (!isset($_SESSION['user']) && !in_array($access['role'], ['admin', 'owner']) ) {

            header('Location: /dashboard');
            exit();
        }

        Auth::AuthJWT();
    }
}

class Owner
{
    public function handle()
    {
        // If user is authenticated as admin, continue
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'owner') {
            return;
        }

        header('Location: /dashboard');
        exit();
    }
}

class Host
{
    public function handle()
    {
        // If the request is coming from the allowed host, continue
        $allowedHost = $_SERVER['HTTP_HOST'];
        $currentHost = $_SERVER['SERVER_NAME'];

        if ($allowedHost === $currentHost) {
            return;
        }

        header('Location: /dashboard');
        exit();
    }
}
