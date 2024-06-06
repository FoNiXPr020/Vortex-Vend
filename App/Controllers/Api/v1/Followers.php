<?php

namespace App\Controllers\Api\v1;

use Core\Auth;
use Core\Database;
use Core\Session;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json');

class Followers
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

    public function follow($followerid)
    {
        // Check if follower if already following user
        $follower = $this->database->Query("SELECT * FROM followers WHERE user_id = ? AND follower_id = ?", [$this->user_id, $followerid], "SELECT") ?? null;

        if ($follower) {
            header('HTTP/1.1 409 Conflict');
            echo json_encode(["status" => 409, "message" => "Already following"]);
            exit();
        }

        $this->database->Insert('followers', [
            'user_id' => $this->user_id,
            'follower_id' => $followerid
        ]);
        header('HTTP/1.1 200 OK');
        echo json_encode(["status" => 200, "message" => "Followed"]);
    }

    public function unfollow($followerid)
    {
        // Check if follower if already following user
        $follower = $this->database->Query("SELECT * FROM followers WHERE user_id = ? AND follower_id = ?", [$this->user_id, $followerid], "SELECT") ?? null;

        if (!$follower) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(["status" => 404, "message" => "Follower not found"]);
            exit();
        }

        $this->database->Query("DELETE FROM followers WHERE user_id = ? AND follower_id = ?", [$this->user_id, $followerid], "DELETE");
        header('HTTP/1.1 200 OK');
        echo json_encode(["status" => 400, "message" => "Unfollowed"]);
    }

    public function checkFollowStatus($followerid)
    {
        $status = $this->database->Query("SELECT COUNT(*) AS count FROM followers WHERE user_id = ? AND follower_id = ?", [$this->user_id, $followerid], "SELECT")[0]['count'];
        $is_following = $status > 0 ? 1 : 0;
        echo json_encode([ "status" => 200 , "is_following" => $is_following]);
    }

    public function getFollowers($id)
    {
        // SELECT users.* FROM followers JOIN users ON followers.user_id = users.id WHERE followers.follower_id = ?

        $followers = $this->database->Query("SELECT users.* FROM followers JOIN users ON followers.user_id = users.id WHERE followers.follower_id = ?", [$id], "SELECT");

        if (!$followers) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(["status" => 404, "message" => "Followers not found"]);
            exit();
        }

        header('HTTP/1.1 200 OK');
        echo json_encode(["status" => 200, "followers" => $followers]);
    }

    public function getFollowing($id)
    {
        $following = $this->database->Query("SELECT users.* FROM followers JOIN users ON followers.follower_id = users.id WHERE followers.user_id = ?", [$id], "SELECT");

        if (!$following) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(["status" => 404, "message" => "Following not found"]);
            exit();
        }

        header('HTTP/1.1 200 OK');
        echo json_encode(["status" => 200, "following" => $following]);
    }
}
