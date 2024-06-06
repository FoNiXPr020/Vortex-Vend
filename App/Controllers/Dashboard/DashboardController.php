<?php

namespace App\Controllers\Dashboard;

use Core\Database;
use Core\Functions;
use Core\Session;
use Core\Validation;
use Core\App;
use Core\Router;
use \Firebase\JWT\JWT;
use Google\Client;

class DashboardController
{
    protected $database;
    protected $errors;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->errors = new Functions();
    }
    public function index()
    {
        //Functions::dd($_SESSION);
        $username = Router::getParam('username');

        if (isset($username)) {
            $user = $this->database->Query("SELECT * FROM users WHERE username = ?", [$username], "SELECT")[0] ?? null;

            if (!$user)
                return Router::error(404);
        } else {
            $user = App::getUser();
            $user = $this->database->Query("SELECT * FROM users WHERE id = ?", [$user['user_id']], "SELECT")[0] ?? null;
        }

        // Get seller from the products table
        $seller = $this->database->Query("SELECT * FROM products WHERE seller_id = ?", [$user['id']], "SELECT")[0] ?? null;
        // Get customers of a seller from the transactions table
        $customers = $this->database->Query("SELECT DISTINCT users.* FROM users INNER JOIN transactions ON (users.id = transactions.buyer_id) WHERE transactions.seller_id = ? AND users.id != ?", [$user['id'], $user['id']], "SELECT") ?? null;
        // get followers of a user
        $followers = $this->database->Query("SELECT users.* FROM followers JOIN users ON followers.user_id = users.id WHERE followers.follower_id = ?", [$user['id']], "SELECT") ?? null;
        // get following of a user
        $following = $this->database->Query("SELECT users.* FROM followers JOIN users ON followers.follower_id = users.id WHERE followers.user_id = ?", [$user['id']], "SELECT") ?? null;
        // get products of a seller started from the last posted product
        $products = $this->database->Query("SELECT * FROM products WHERE seller_id = ? ORDER BY id DESC", [$user['id']], "SELECT");
        $sales = $this->database->Query("SELECT * FROM products WHERE seller_id = ? AND status = 'sold' ORDER BY id DESC", [$user['id']], "SELECT");
        // get purchases made in transactions of $user
        $purchases = $this->database->Query("SELECT products.*, sellers.username, sellers.profile_img FROM products 
        INNER JOIN transactions ON products.id = transactions.product_id 
        INNER JOIN users AS sellers ON products.seller_id = sellers.id
        WHERE transactions.buyer_id = ?", [$user['id']], "SELECT") ?? null;

        

        Functions::view("dashboard/dashboard.view.php", [
            'data' => Session::get('data'),
            'user' => $user,
            'seller' => $seller,
            'products' => $products,
            'sales' => $sales,
            'customers' => $customers,
            'followers' => $followers,
            'following' => $following,
            'purchases' => $purchases
        ]);
    }

    public function products()
    {
        $user = App::getUser();
        $products = $this->database->Query("SELECT * FROM products WHERE seller_id = ?", [$user['user_id']], "SELECT");
        Functions::view("dashboard/products.view.php", [
            'data' => Session::get('data'),
            'user' => $user,
            'products' => $products
        ]);
    }
}
