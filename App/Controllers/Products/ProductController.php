<?php

namespace App\Controllers\Products;

use Core\Database;
use Core\Functions;
use Core\Session;
use Core\App;
use Core\Router;
use Core\Validation;
use Dotenv\Validator;
use Google\Service\Compute\Zone;

class ProductController
{
    protected $database;
    protected $errors;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->errors = new Functions();
    }
    public function create()
    {
        $user = App::getUser();

        Functions::view("products/create.view.php", [
            'data' => Session::get('data'),
            'user' => $user
        ]);
    }

    public function store()
    {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity'],
            'image' => $_FILES['image']
        ];

        if (isset($data["image"]["tmp_name"]) && !empty($data["image"]["tmp_name"])) {
            $uploaded_image = App::uploadImage($data['image'], "assets/uploads/products/");
        } else {
            $this->errors->error('image', "Please upload an image");
            return Functions::RedirectSession("/create-product", $data, $this->errors->errors());
        }

        // Validation
        switch (true) {
            case !Validation::String($data['title'], 3, 30):
                $this->errors->error('title', "Title must be between 3 and 60 characters");
                return Functions::RedirectSession("/create-product", $data, $this->errors->errors());
                break;
            case !Validation::SpecialCharacter($data['quantity']):
                $this->errors->error('quantity', "Quantity must not contain special characters");
                return Functions::RedirectSession("/create-product", $data, $this->errors->errors());
                break;
        }

        if ($uploaded_image['status'] != "success") {
            $this->errors->error('image', $uploaded_image['message']);
            return Functions::RedirectSession("/create-product", $data, $this->errors->errors());
        }

        $create = $this->database->insert('products', [
            'seller_id' => App::getUser()['user_id'],
            'name' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'image' => $uploaded_image['path'],
            'status'  => 1,
        ], true);

        if (!$create) {
            Functions::Redirect("/create-product");
        }

        return Functions::Redirect("/products/{$create}");
    }

    public function show($id)
    {
        $token = $_GET['token'] ?? null;

        // Fetch product from the database
        $product = $this->database->Query("SELECT * FROM products WHERE id = ?", [$id], "SELECT")[0] ?? null;

        if (!$product) {
            Router::error(404);
        }

        // Initialize viewed products array in session if not set
        if (!isset($_SESSION['viewed_products'])) {
            $_SESSION['viewed_products'] = [];
        }

        // Fetch seller information
        $seller = $this->database->Query("SELECT * FROM users WHERE id = ?", [$product['seller_id']], "SELECT")[0] ?? null;

        if (!$seller) {
            Router::error(404);
        }

        // Update view count if the product hasn't been viewed in this session
        if (!in_array($product['id'], $_SESSION['viewed_products'])) {
            $this->database->Query("UPDATE products SET views = views + 1 WHERE id = ?", [$product['id']], "UPDATE");
            $_SESSION['viewed_products'][] = $product['id'];
        }

        // Render the product view
        Functions::view("products/show.view.php", [
            'product' => $product,
            'seller' => $seller,
            'token' => $token
        ]);
    }

    public function update($id)
    {
        // Fetch product from the database
        $product = $this->database->Query("SELECT * FROM products WHERE id = ?", [$id], "SELECT")[0] ?? null;

        if (!$product) {
            Router::error(404);
        }

        $user = App::getUser();
        if ($product['seller_id'] != $user['user_id']) {
            Router::error(404);
        }

        Functions::view("dashboard/update.view.php", [
            'data' => Session::get('data'),
            'user' => $user,
            'product' => $product,
        ]);
    }

    public function updateSubmit($id)
    {

        $product = $this->database->Query("SELECT * FROM products WHERE id = ?", [$id], "SELECT")[0] ?? null;

        if ($product['status'] == 1) {
            $this->errors->error('status', "Product is not available");
            return Functions::RedirectSession("/update-product/{$id}", [], $this->errors->errors());
        }

        if (!$product) {
            Router::error(404);
        }

        $user = App::getUser();
        if ($product['seller_id'] != $user['user_id']) {
            Router::error(404);
        }

        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity'],
            'image' => $_FILES['image']
        ];

        if (isset($data["image"]["tmp_name"]) && !empty($data["image"]["tmp_name"])) {
            $uploaded_image = App::uploadImage($data['image'], "assets/uploads/products/");
        } else {
            $uploaded_image = [
                'status' => 'success',
                'path' => $product['image']
            ];
        }

        // Validation
        switch (true) {
            case !Validation::String($data['title'], 3, 60):
                $this->errors->error('title', "Title must be between 3 and 60 characters");
                return Functions::RedirectSession("/update-product/{$id}", $data, $this->errors->errors());
                break;
            case !Validation::SpecialCharacter($data['quantity']):
                $this->errors->error('quantity', "Quantity must not contain special characters");
                return Functions::RedirectSession("/update-product/{$id}", $data, $this->errors->errors());
                break;
        }

        if ($uploaded_image['status'] != "success") {
            $this->errors->error('image', $uploaded_image['message']);
            return Functions::RedirectSession("/update-product/{$id}", $data, $this->errors->errors());
        }

        $update = $this->database->Query("UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, image = ? WHERE id = ?", [
            $data['title'],
            $data['description'],
            $data['price'],
            $data['quantity'],
            $uploaded_image['path'],
            $id
        ], "UPDATE");

        if ($update) {
            $this->errors->success("update-product", "Product updated successfully");
            return Functions::RedirectSession("/update-product/{$id}", [], [], $this->errors->succeed());
        } else {
            $this->errors->error("update-product", "Something went wrong");
            return Functions::RedirectSession("/update-product/{$id}", $data, $this->errors->errors());
        }
    }

    public function delete($id)
    {

        $product = $this->database->Query("SELECT * FROM products WHERE id = ?", [$id], "SELECT")[0] ?? null;

        if (!$product) {
            Router::error(404);
        }

        $user = App::getUser();
        if ($product['seller_id'] != $user['user_id']) {
            Router::error(404);
        }

        if ($_POST['id'] != $id) {
            Router::error(404);
        }

        $delete = $this->database->Query("DELETE FROM products WHERE id = ?", [$id], "DELETE");

        if ($delete) {
            $this->errors->success("delete-product", "Product deleted successfully");
            return Functions::RedirectSession("/products", [], [], $this->errors->succeed());
        } else {
            $this->errors->error("delete-product", "Something went wrong");
            return Functions::RedirectSession("/update-product/{$id}", [], $this->errors->errors());
        }
    }
}
