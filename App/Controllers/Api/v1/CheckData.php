<?php

namespace App\Controllers\Api\v1;

use Core\Auth;
use Core\Database;
use Core\App;
use Core\Session;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json');

class CheckData
{
    protected $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function checkEmail($email)
    {
        if(!isset($email)) {
            header('Content-Type: application/json');
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Email is required"
                ]
            );
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Content-Type: application/json');
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Invalid email address"
                ]
            );
            exit();
        }

        $user = $this->database->Query("SELECT COUNT(*) AS count FROM users WHERE email_address = ?", [$email], "SELECT")[0];
        $count = $user['count'];

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        echo json_encode(
            [
                'status' => 200,
                'exists' => $count > 0,
                "message" => "Email " . ($count > 0 ? "already exists" : "not found")." in our records",
                "email" => $email
            ]
        );
    }

    public function checkUsername($username)
    {
        if(!isset($username)) {
            header('Content-Type: application/json');
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Username is required"
                ]
            );
            exit();
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            header('Content-Type: application/json');
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Invalid username"
                ]
            );
            exit();
        }

        $user = $this->database->Query("SELECT COUNT(*) AS count FROM users WHERE username = ?", [$username], "SELECT")[0];
        $count = $user['count'];

        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        echo json_encode(
            [
                'status' => 200,
                'exists' => $count > 0,
                "message" => "Username " . ($count > 0 ? "already exists" : "not found")." in our records",
                "username" => $username
            ]
        );
    }
}

