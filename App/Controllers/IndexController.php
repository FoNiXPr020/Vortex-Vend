<?php

namespace App\Controllers;

use Core\Database;
use Core\Functions;
use Core\Router;
use Core\App;
use Core\Session;
use Core\Auth;
use Core\Paypal;
use \App\Controllers\Dashboard\DashboardController;

class IndexController
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
        // Base URL
        $base = App::getURI();

        // API Endpoints
        $endpoints = [
            'newArrivals' => "/api/v1/explore/new-arrivals",
            'topSellers' => "/api/v1/explore/top-sellers",
            'products' => "/api/v1/explore/products"
        ];

        // Initialize data array
        $data = [];

        // Loop through each endpoint to fetch data
        foreach ($endpoints as $key => $endpoint) {
            $response = App::fetchApiGET($base . $endpoint);
            if ($response !== null) {
                $data[$key] = $response['data'];
            } else {
                $data[$key] = []; // Handle cases where the response is null
            }
        }

        // Extract the specific variables from the data array
        $newArrivals = isset($data['newArrivals']) ? $data['newArrivals'] : [];
        $topSellers = isset($data['topSellers']) ? $data['topSellers'] : [];
        $products = isset($data['products']) ? $data['products'] : [];

        // Render the view
        Functions::view("index.view.php", [
            "newArrivals" => $newArrivals,
            "topSellers" => $topSellers,
            "products" => $products
        ]);
    }

    public function userProfile($username)
    {
        $dashboard = new DashboardController();
        $dashboard->index();
    }

    public function exploreProfile($username)
    {
        $app = new App();
        $user = $this->database->Query("SELECT * FROM users WHERE username = ?", [$username], "SELECT")[0] ?? null;

        $products = $app->fetchUserProducts($username);
        $sales = $app->fetchUserSales($username);
        $followers = $app->fetchUserFollowers($username);
        $following = $app->fetchUserFollowing($username);

        Functions::view(
            "dashboard/explore.view.php",
            [
                "user" => $user,
                "products" => $products,
                "sales" => $sales,
                "followers" => $followers,
                "following" => $following
            ]
        );
    }

    public function explore()
    {
        $app = new App();
        $limit = 12;
        $products = $app->fetchMoreProducts(0, $limit);
        $Arrivals = $app->fetchMoreProducts(0, $limit);
        $populars = $app->fetchMostPopular(0, $limit);

        Functions::view(
            "explore/explore.view.php",
            [
                "products" => $products,
                "Arrivals" => $Arrivals,
                "populars" => $populars,
                "offset" => $limit
            ]
        );
    }

    public function Checkout($id)
    {
        $product = $this->database->Query("SELECT * FROM products WHERE id = ?", [$id], "SELECT")[0] ?? null;


        if (!$product) {
            Router::error(404);
        }

        if (!Session::get("user")) {
            $this->errors->error('not_logged_in', "Please login or register to continue your purchase.");
            return Functions::RedirectSession("/login", [], $this->errors->errors());
        }

        $user = App::getUser();
        $base = PaypalCheckoutNow();

        switch (true) {
            case $user['user_id'] == $product['seller_id']:
                $this->errors->error('product', "You cannot purchase your own product.");
                return Functions::RedirectSession("/products/{$id}", [], $this->errors->errors());
                break;

            case $user['verified'] != 1:
                $this->errors->error('product', "Please verify your account to continue your purchase.");
                return Functions::RedirectSession("/products/{$id}", [], $this->errors->errors());
                break;

            case $product["status"] == 1:
                $this->errors->error('product', "This product is currently unavailable.");
                return Functions::RedirectSession("/products/{$id}", [], $this->errors->errors());
                break;

            case isset($_POST['_token']):
                $token = $_POST['_token'];
                return Functions::Redirect("$base?token=$token");
                break;
        }

        $accesstoken = Paypal::GetAccessToken();

        $create = Paypal::CreateOrder($accesstoken, $id, $product["price"]);

        if (!$create) {
            $this->errors->error('payment', "Something went wrong. Please try again later.");
            return Functions::RedirectSession("/products/{$id}", [], $this->errors->errors());
        }

        $link = $create["links"][1]["href"];
        return Functions::Redirect($link);
    }

    public function success()
    {
        $table = "transactions";
        $token = $_GET['token'];
        $payer_id = $_GET['PayerID'];

        if (!$token) {
            return Functions::Redirect("/dashboard");
        }

        $user = App::getUser();
        $tokenExists = $this->database->Exists($table, "token", $token);

        // Check if any transactions exist with the given token
        if ($tokenExists) {
            $this->errors->success('success', "Payment already completed. thank you.");
            return Functions::RedirectSession("/{$user['username']}", [], [], $this->errors->succeed());
        }

        // Retrieve the session object
        $accesstoken = Paypal::GetAccessToken();
        $session = Paypal::CaptureOrder($accesstoken, $token);

        if ($session['status'] !== 'COMPLETED') {
            // Payment failed, handle the error
            $this->errors->error('payment', "Something went wrong. Please try again later. contact support if issue persists.");
            return Functions::RedirectSession("/{$user['username']}", [], $this->errors->errors());
        }

        $product_id = $session["purchase_units"][0]["payments"]["captures"][0]["custom_id"];

        // We need to get product info + user info of his username and profile_img from users table
        $app = new App();
        $product = $app->fetchProductByID($product_id);

        $token = $session["id"];
        $buyer_id = $user['user_id'];
        $seller_id = $product['seller_id'];

        $result = $this->database->Insert($table, [
            'buyer_id' => $buyer_id,
            'seller_id' => $seller_id,
            'product_id' => $product_id,
            'token' => $token,
            'payer_id' => $payer_id
        ]);
        $this->database->Query("UPDATE products SET status = 2 WHERE id = ?", [$product_id], "UPDATE");

        if( !$result ) {
            $this->errors->error('payment', "Something went wrong. Please try again later. contact support if issue persists.");
            return Functions::RedirectSession("/{$user['username']}", [], $this->errors->errors());
        }

        $path = BASE_TEMPLATE . "success_payment.php";
        $data = [
            'token' => $token,
            'payer_id' => $payer_id,
            'user' => $user,
            'product' => $product
        ];
        App::SendEmail($path, $user['email_address'], "Payment Successful", $data);

        Functions::view("dashboard/success.view.php",
        [
            "user" => $user,
            "product" => $product
        ]);
    }

    public function downlaod()
    {
        $user = App::getUser();
        $product_id = $_POST['invoice_id'];

        // Using product_id to get product info and buyer info from transactions table and users table
        $app = new App();
        $data = $app->fetchProductByIDofBuyer($product_id);

        if ( !$data ) {
            return;
        }

        // Functions::dd($data);

        $filename = strtolower($user['username']).'_'. $product_id .'_invoice.pdf';
        $path = BASE_TEMPLATE . "download-invoice.php";
        
        App::convertHtmlToPdf($path, $filename, $data);

        Functions::view("dashboard/download.view.php", ["user" => $user]);
    }
}
