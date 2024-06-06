<?php

namespace App\Controllers\Api\v1;

use Core\Database;
use Core\App;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json');

class Products
{
    protected $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function Products()
    {
        $discoverQuery = "SELECT 
                p.id AS product_id, 
                p.name AS product_name, 
                p.description, 
                p.price, 
                p.quantity, 
                p.image, 
                p.status, 
                u.id AS seller_id,
                u.username AS seller_username, 
                u.profile_img AS seller_profile_img
            FROM products p
            JOIN users u ON p.seller_id = u.id
            ORDER BY RAND()
        ";

        // Discover Products $discover randomly
        $products = $this->database->Query($discoverQuery, [], "SELECT");
        echo json_encode([
            "status" => 200,
            "data" => $products,
        ]);
    }

    public function ProductsLoadMore()
    {
        $app = new App();
        // Get the offset and limit from the request, with defaults
        $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
        $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 12;

        // Fetch the products based on the offset and limit
        $products = $app->fetchMoreProducts($offset, $limit);

        // Return the products as a JSON response
        header('Content-Type: application/json');
        echo json_encode(['data' => $products]);
    }

    public function ProductsofUser($username)
    {
        $productsQuery = "SELECT 
                p.id AS product_id, 
                p.name AS product_name, 
                p.description, 
                p.price, 
                p.quantity, 
                p.image, 
                p.status, 
                u.id AS seller_id,
                u.username AS seller_username, 
                u.profile_img AS seller_profile_img
            FROM products p
            JOIN users u ON p.seller_id = u.id
            WHERE u.username = ?
            ORDER BY p.created_at DESC
        ";
        $products = $this->database->Query($productsQuery, [$username], "SELECT");
        echo json_encode([
            "status" => 200,
            "data" => $products,
        ]);
    }

    public function NewArrivals()
    {
        $newArrivalsQuery = "SELECT 
                p.id AS product_id, 
                p.name AS product_name, 
                p.description, 
                p.price, 
                p.quantity, 
                p.image, 
                p.status, 
                u.id AS seller_id, 
                u.username AS seller_username, 
                u.profile_img AS seller_profile_img
            FROM products p
            JOIN users u ON p.seller_id = u.id
            ORDER BY p.created_at DESC
        ";
        $newArrivals = $this->database->Query($newArrivalsQuery, [], "SELECT");
        echo json_encode([
            "status" => 200,
            "data" => $newArrivals,
        ]);
    }

    public function TopSellers()
    {
        $topsellersQuery = "SELECT id, username, profile_img FROM users 
        WHERE id IN 
        (SELECT seller_id FROM transactions GROUP BY seller_id ORDER BY COUNT(seller_id) DESC)
        ";

        // Top Sellers users $topSellers by counting the top seller_id in transactions
        $topSellers = $this->database->Query($topsellersQuery, [], "SELECT");
        echo json_encode([
            "status" => 200,
            "data" => $topSellers,
        ]);
    }

    function NewArrivalsLoadMore() {

        $app = new App();
        // Get the offset and limit from the request, with defaults
        $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
        $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 12;

        // Fetch the products based on the offset and limit
        $products = $app->fetchMoreProducts($offset, $limit);

        // Return the products as a JSON response
        header('Content-Type: application/json');
        echo json_encode(['data' => $products]);
    }

    function MostPopularLoadMore() {

        $app = new App();
        // Get the offset and limit from the request, with defaults
        $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
        $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 12;

        // Fetch the products based on the offset and limit
        $products = $app->fetchMostPopular($offset, $limit);

        // Return the products as a JSON response
        header('Content-Type: application/json');
        echo json_encode(['data' => $products]);
    }


}
