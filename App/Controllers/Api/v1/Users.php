<?php

namespace App\Controllers\Api\V1;

use Core\Functions;
use Core\Router;
use Core\Database;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

class Users {

    protected $database;

    public function __construct() {
        $this->database = Database::getInstance();
    }

    public function index() {

        $users = Database::getInstance()->Query("SELECT * FROM users_2");

        $users = array_map(function ($user) {
            unset($user['password']);
            //unset($user['address']);
            unset($user['phone_number']);
            return $user;
        }, $users);
        echo json_encode(
            [
                'data' => $users
            ]
        );
    }
}
