<?php

namespace App\Controllers\Api\v1;

use Core\Auth;
use Core\Database;
use Core\Session;
use Core\App;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json');

class Account
{
    protected $database;
    protected $user_id;

    public function __construct()
    {
        if (!Session::get('user')) {
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(
                [
                    'status' => 401,
                    'message' => "Unauthorized"
                ]
            );
            exit();
        }

        $this->user_id = Session::get('user')['user_id'];
        $this->database = Database::getInstance();
    }

    public function changeCustomer()
    {
        $user = App::getUser();

        // Get status from body
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['status'])) {
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Bad Request: Status field missing"
                ]
            );
            exit();
        }

        // Validate the status value
        $status = strtolower($data['status']); // Convert status to lowercase for case-insensitive comparison
        if ($status !== 'public' && $status !== 'private') {
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Bad Request: Status must be either 'public' or 'private'"
                ]
            );
            exit();
        }

        // Update user status in the database
        $result = $this->database->Query("UPDATE users SET customers_status = ? WHERE id = ?", [$status, $this->user_id], "UPDATE");
        $user['customers_status'] = $status;
        App::setUser('user', $user);

        if ($result) {
            // Return the updated status
            echo json_encode(
                [
                    'status' => 200,
                    'message' => "Customer privacy updated successfully to " . ucfirst($status),
                    'data' => ['status' => $status] // Include the updated status in the response
                ]
            );
        } else {
            echo json_encode(
                [
                    'status' => 500,
                    'message' => "Internal Server Error: Failed to update user status"
                ]
            );
        }
    }

    public function changeFollowers()
    {
        $user = App::getUser();

        // Get status from body
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['status'])) {
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Bad Request: Status field missing"
                ]
            );
            exit();
        }

        // Validate the status value
        $status = strtolower($data['status']); // Convert status to lowercase for case-insensitive comparison
        if ($status !== 'public' && $status !== 'private') {
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Bad Request: Status must be either 'public' or 'private'"
                ]
            );
            exit();
        }

        // Update user status in the database
        $result = $this->database->Query("UPDATE users SET followers_status = ? WHERE id = ?", [$status, $this->user_id], "UPDATE");
        $user['followers_status'] = $status;
        App::setUser('user', $user);

        if ($result) {
            // Return the updated status
            echo json_encode(
                [
                    'status' => 200,
                    'message' => "Followers privacy updated successfully to " . ucfirst($status),
                    'data' => ['status' => $status] // Include the updated status in the response
                ]
            );
        } else {
            echo json_encode(
                [
                    'status' => 500,
                    'message' => "Internal Server Error: Failed to update user status"
                ]
            );
        }
    }

    public function changeFollowing()
    {
        $user = App::getUser();

        // Get status from body
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['status'])) {
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Bad Request: Status field missing"
                ]
            );
            exit();
        }

        // Validate the status value
        $status = strtolower($data['status']); // Convert status to lowercase for case-insensitive comparison
        if ($status !== 'public' && $status !== 'private') {
            echo json_encode(
                [
                    'status' => 400,
                    'message' => "Bad Request: Status must be either 'public' or 'private'"
                ]
            );
            exit();
        }

        // Update user status in the database
        $result = $this->database->Query("UPDATE users SET following_status = ? WHERE id = ?", [$status, $this->user_id], "UPDATE");
        $user['following_status'] = $status;
        App::setUser('user', $user);
        
        if ($result) {
            // Return the updated status
            echo json_encode(
                [
                    'status' => 200,
                    'message' => "Following privacy updated successfully to " . ucfirst($status),
                    'data' => ['status' => $status] // Include the updated status in the response
                ]
            );
        } else {
            echo json_encode(
                [
                    'status' => 500,
                    'message' => "Internal Server Error: Failed to update user status"
                ]
            );
        }
    }
}
