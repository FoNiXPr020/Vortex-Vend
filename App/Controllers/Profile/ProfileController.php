<?php

namespace App\Controllers\Profile;

use Core\Database;
use Core\Functions;
use Core\Session;
use Core\Validation;
use Core\App;

use function PHPSTORM_META\map;

class ProfileController
{
    protected $database;
    protected $functions;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->functions = new Functions();
    }

    public function index()
    {
        $user = App::getUser();
        // Count of products of a user
        $sales = $this->database->Query("SELECT * FROM products WHERE seller_id = ? AND status = 'sold' ORDER BY id DESC", [$user['user_id']], "SELECT");
        $followers = $this->database->Query("SELECT users.* FROM followers JOIN users ON followers.user_id = users.id WHERE followers.follower_id = ?", [$user['user_id']], "SELECT") ?? null;
        $products = $this->database->Query("SELECT * FROM products WHERE seller_id = ? ORDER BY id DESC", [$user['user_id']], "SELECT");

        Functions::view("profile/profile.view.php", [
            'data' => Session::get('data'),
            'user' => $user,
            'products' => $products,
            'sales' => $sales,
            'followers' => $followers
        ]);
    }

    public function update()
    {
        $table = "users";
        $user = App::getUser();
        $profile_pic = false;

        $data = [
            "username" => $_POST["username"],
            "first_name" => $_POST["first_name"],
            "last_name" => $_POST["last_name"],
            "address" => $_POST["address"],
            "age" => $_POST["age"],
            "phone_number" => $_POST["phone_number"],
            "profile_bio" => $_POST["profile_bio"]
        ];

        switch (true) {
            case !Validation::SpecialCharacter($data['username']):
                $this->functions->error('username', "Username must not contain special characters");
                return Functions::RedirectSession("/profile", $data, $this->functions->errors());
                break;

            case !Validation::String($data['username'], 6, 20):
                $this->functions->error('username', "Username must be between 6 and 20 characters");
                return Functions::RedirectSession("/profile", $data, $this->functions->errors());
                break;

            case !Validation::String($data['profile_bio'], 1, 160):
                $this->functions->error('profile_bio', "Profile bio must be between 1 and 160 characters");
                return Functions::RedirectSession("/profile", $data, $this->functions->errors());
                break;
        }

        // Filter out unchanged data
        $data = array_filter($data, function ($key) use ($user) {
            return $_POST[$key] != $user[$key];
        }, ARRAY_FILTER_USE_KEY);

        if ($_FILES['file-upload']['error'] == 0) {
            $uploadImage = App::uploadImage($_FILES['file-upload'], "assets/uploads/profiles/", $user["username"]);

            // Update session with the new profile image if uploaded successfully
            if ($uploadImage['status'] == "success") {
                // lets update the database
                $this->database->Query("UPDATE {$table} SET `profile_img` = ? WHERE `id` = ?", [$uploadImage['path'], $user['user_id']], "UPDATE");
                $user['profile_img'] = $uploadImage['path'];
                App::setUser("user", $user);
                $profile_pic = true;
            } elseif ($uploadImage['status'] == "error") {
                $this->functions->error('image', $uploadImage['message']);
                return Functions::RedirectSession("/profile", $data, $this->functions->errors());
            }
        }

        if (!empty($data)) {
            $setString = "";
            $params = [];
            foreach ($data as $key => $value) {
                $setString .= "`$key` = ?, ";
                $params[] = $value;
            }
            $setString = rtrim($setString, ", ");
            $params[] = $user['user_id'];

            $query = "UPDATE {$table} SET {$setString} WHERE `id` = ?";
            $this->database->Query($query, $params, "UPDATE");

            // Update user session with new updated data
            foreach ($data as $key => $value) {
                $user[$key] = $value;
            }
            App::setUser("user", $user); // Updates the user session

            $this->functions->success('updated', $profile_pic ? "Your profile updated successfully and new profile image uploaded!" : "Your profile updated successfully!");
            return Functions::RedirectSession("/profile", [], [], $this->functions->succeed());
        } else {
            $this->functions->success('already', $profile_pic ? "Your profile updated already updated and new profile image uploaded" : "Your profile is already updated!");
            return Functions::RedirectSession("/profile", [], [], $this->functions->succeed());
        }
    }

    public function updateinsuccess()
    {
        $table = "users";
        $user = App::getUser();

        $data = [
            "address" => $_POST["address"],
            "phone_number" => $_POST["phone_number"]
        ];

        // Filter out unchanged data
        $data = array_filter($data, function ($key) use ($user) {
            return $_POST[$key] != $user[$key];
        }, ARRAY_FILTER_USE_KEY);

        if (!empty($data)) {
            $setString = "";
            $params = [];
            foreach ($data as $key => $value) {
                $setString .= "`$key` = ?, ";
                $params[] = $value;
            }
            $setString = rtrim($setString, ", ");
            $params[] = $user['user_id'];

            $query = "UPDATE {$table} SET {$setString} WHERE `id` = ?";
            $this->database->Query($query, $params, "UPDATE");

            // Update user session with new updated data
            foreach ($data as $key => $value) {
                $user[$key] = $value;
            }
            App::setUser("user", $user); // Updates the user session

            $this->functions->success('updated', "Your profile updated successfully!");
            return Functions::RedirectSession("/{$user['username']}", [], [], $this->functions->succeed());
        } else {
            $this->functions->success('already', "Your profile is already updated!");
            return Functions::RedirectSession("/{$user['username']}", [], [], $this->functions->succeed());
        }
    }
}
