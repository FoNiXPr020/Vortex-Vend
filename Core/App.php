<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Dompdf\Dompdf;

class App
{
    protected $database;
    protected $errors;

    public function __construct()
    {
        $this->database = Database::getInstance();
        $this->errors = new Functions();
    }

    public static function SessionLogin($info)
    {
        return [
            'user_id' => $info['id'],
            'auth_id' => $info['auth_id'],
            'first_name' => $info['first_name'],
            'last_name' => $info['last_name'],
            'username' => $info['username'],
            'email_address' => $info['email_address'],
            'password' => $info['password'],
            'role' => $info['role'],
            'phone_number' => $info['phone_number'],
            'address' => $info['address'],
            'age' => $info['age'],
            'verified' => $info['verified'],
            'created_at' => $info['created_at'],
            'updated_at' => $info['updated_at'],
            'profile_img' => $info['profile_img'],
            'profile_bio' => $info['profile_bio'],
            'status' => $info['status'],
            'customers_status' => $info['customers_status'],
            'followers_status' => $info['followers_status'],
            'following_status' => $info['following_status']
        ];
    }

    public static function getUser()
    {
        if (!Session::get('user'))
            return Functions::redirect('/logout');

        return Session::get('user');
    }

    public static function setUser($key, $user)
    {
        // Assuming session_start() is called somewhere in your application initialization
        Session::put($key, $user);
    }

    public function getCurrentURL()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    public static function getURI()
    {
        $uri = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
        $uri .= '://' . $_SERVER['HTTP_HOST'];
        return $uri;
    }

    public function fetchMoreProducts($offset, $limit)
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
            ORDER BY p.created_at DESC
            LIMIT $offset, $limit
        ";
        $products = $this->database->Query($productsQuery, [], "SELECT");
        return $products;
    }

    public function fetchUserProducts($username)
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
        return $products;
    }

    public function fetchUserSales($username)
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
            WHERE u.username = ? AND p.status = 'sold'
            ORDER BY p.created_at DESC
        ";
        $products = $this->database->Query($productsQuery, [$username], "SELECT");
        return $products;
    }

    public function fetchUserFollowers($username)
    {
        // Step 1: Fetch the user ID by username
        $userIdQuery = "SELECT id FROM users WHERE username = ?";
        $userResult = $this->database->Query($userIdQuery, [$username], "SELECT");

        // Check if user exists
        if (empty($userResult)) {
            return []; // No such user found, return empty array
        }

        $userId = $userResult[0]['id'];

        // Step 2: Fetch the profiles of users who are following this user
        $followersQuery = "SELECT users.* FROM followers JOIN users ON followers.user_id = users.id WHERE followers.follower_id = ?";

        $followers = $this->database->Query($followersQuery, [$userId], "SELECT");

        return $followers;
    }

    public function fetchUserFollowing($username)
    {
        // Step 1: Fetch the user ID by username
        $userIdQuery = "SELECT id FROM users WHERE username = ?";
        $userResult = $this->database->Query($userIdQuery, [$username], "SELECT");

        // Check if user exists
        if (empty($userResult)) {
            return []; // No such user found, return empty array
        }

        $userId = $userResult[0]['id'];

        // Step 2: Fetch the profiles of users who are following this user
        $followersQuery = "SELECT users.* FROM followers JOIN users ON followers.follower_id = users.id WHERE followers.user_id = ?";

        $followers = $this->database->Query($followersQuery, [$userId], "SELECT");

        return $followers;
    }

    public function fetchProductByID($productId)
    {
        $Query = "SELECT 
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
        WHERE p.id = ?
        ";
        $product = $this->database->Query($Query, [$productId], "SELECT")[0] ?? null;
        return $product;
    }
    public function fetchProductByIDofBuyer($productId)
    {
        // We will got product info and buyer info based on transaction table and transaction_date from transaction table
        $Query = "SELECT
        p.id AS product_id,
        p.name AS product_name,
        p.description,
        p.price,
        p.quantity,
        p.image,
        p.status,
        u.id AS buyer_id,
        u.username AS buyer_username,
        u.email_address AS buyer_email,
        u.phone_number AS buyer_phone,
        t.transaction_date AS transaction_date, -- Added comma here
        t.token AS transaction_token
        FROM products p
        JOIN transactions t ON p.id = t.product_id
        JOIN users u ON t.buyer_id = u.id
        WHERE p.id = ?
        ";
        $product = $this->database->Query($Query, [$productId], "SELECT")[0] ?? null;
        return $product;
    }

    public function fetchMostPopular($offset, $limit)
    {
        // we will get the most popular products by views coulmn in products table and products info and users info like username and profile_img
        $mostPopularQuery = "SELECT 
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
            ORDER BY p.views DESC
            LIMIT $offset, $limit
        ";
        $mostPopular = $this->database->Query($mostPopularQuery, [], "SELECT");
        return $mostPopular;
    }

    public static function fetchApiGET($url)
    {
        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // Log error details for debugging
            error_log('cURL error (' . curl_errno($ch) . '): ' . curl_error($ch));
            curl_close($ch);
            return null;
        }

        // Close cURL
        curl_close($ch);

        // Decode JSON response
        $decodedResponse = json_decode($response, true);

        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Log error details for debugging
            error_log('JSON decode error: ' . json_last_error_msg());
            return null;
        }

        return $decodedResponse;
    }

    public static function downloadImage($imageUrl, $saveDirectory)
    {
        // Fetch image data
        $imageData = file_get_contents($imageUrl);

        if ($imageData !== false) {
            // Extract filename from the URL
            $filename = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_FILENAME);

            // Append .jpg extension to the filename
            $filename .= '.jpg';

            // Save the image data to the file
            $savePath = $saveDirectory . '/' . $filename;
            $result = file_put_contents($savePath, $imageData);

            if ($result !== false) {
                return $savePath; // Return the file path of the saved image
            } else {
                return false; // Failed to save the image
            }
        } else {
            return false; // Failed to fetch image data
        }
    }

    public static function uploadImage($file, $saveDirectory = "assets/uploads/", $username = "")
    {
        $target_dir = $saveDirectory; //"assets/uploads/products/";
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image of 5 MB
        $maxFileSize = 5 * 1024 * 1024;

        // Generate a unique file name beginning with the username if not provided by the user just use unique ID and time
        $unique_name = ($username ? $username . '-' : '') . uniqid() . '-' . time() . '.' . $imageFileType;

        $target_file = $target_dir . $unique_name;

        // Check if image file is an actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return ["status" => "error", "message" => "File is not an image."];
        }

        // Check file size
        if ($file["size"] > $maxFileSize) {
            return ["status" => "error", "message" => "File size exceeds 2.5 MB. Please choose a smaller file."];
        }

        // Allow certain file formats
        $allowedFileTypes = ["jpg", "jpeg", "png"];
        if (!in_array($imageFileType, $allowedFileTypes)) {
            return ["status" => "error", "message" => "Only JPG, JPEG and PNG files are allowed."];
        }

        // Try to upload file
        //Functions::dd($target_file);
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return ["status" => "success", "message" => "File uploaded successfully.", "path" => self::getURI() . '/' . $target_file];
        } else {
            return ["status" => "error", "message" => "Failed to upload file."];
        }
    }

    public function getButtonInfo()
    {
        $currentURL = $this->getCurrentURL();
        switch (true) {
            case Session::has('user'):
                return array('text' => 'Dashboard', 'href' => '/dashboard');
            case strpos($currentURL, '/login') !== false:
                return array('text' => 'Register', 'href' => '/register');
            case strpos($currentURL, '/register') !== false:
                return array('text' => 'Login', 'href' => '/login');
            default:
                return array('text' => 'Login', 'href' => '/login');
        }
    }

    public function getEchoLANG($selectedLanguage)
    {
        switch ($selectedLanguage) {
            case 'en':
                return 'English';
                break;
            case 'es':
                return 'Espanol';
                break;
            case 'fr':
                return 'French';
                break;
            case 'ar':
                return 'Arabic';
                break;
            default:
                return 'English';
                break;
        }
    }

    public static function formatInput($words)
    {
        // Remove all non-alphanumeric characters
        trim($words);

        // Convert the name to lowercase
        $lowercaseName = strtolower($words);

        // Uppercase the first letter of each word
        $formattedName = ucwords($lowercaseName);

        return $formattedName;
    }

    public function getPageTitle()
    {
        // Get the current URL without query parameters
        $currentURL = strtok($this->getCurrentURL(), '?');

        // Extract the page name
        $pageName = basename($currentURL);

        // Format the page title
        if (strpos($pageName, '_') !== false) {
            $pageTitle = ucwords(str_replace('_', ' ', $pageName));
        } else {
            $pageTitle = ucwords($pageName);
        }

        return $pageTitle;
    }

    public static function truncateString($input, $length = 20, $suffix = '...')
    {
        if ($input === null)
            return 'No input provided';

        if (strlen($truncated = substr($input, 0, $length)) < strlen($input)) {
            $truncated .= $suffix;
        }
        return $truncated;
    }

    public static function formattedDate($date)
    {
        // Convert date string to DateTime object
        $expirationDate = new \DateTime($date);

        // Format the date
        $formattedDate = $expirationDate->format('d F, Y');

        return $formattedDate;
    }

    public static function SendEmail($templatePath, $email, $subject = "", $params = [])
    {
        // Get URI can be used in template ( optional )
        $uri = App::getURI();
        // Load HTML template
        ob_start();
        // Load HTML content
        include $templatePath;
        $htmlContent = ob_get_clean();

        // Instantiation and setup of PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST']; // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME']; // SMTP account username
            $mail->Password   = $_ENV['MAIL_PASSWORD'];   // SMTP account password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'];

            //Recipients
            $mail->setFrom('majid@rubiotv.com', 'VortexVend.com');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlContent;

            if ($mail->send())
                return true;
            else
                return false;

            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public static function convertHtmlToPdf($templatePath, $outputFilename = "output.pdf", $params = [])
    {
        // Load HTML template
        ob_start();
        // Load HTML content
        include $templatePath;
        $htmlContent = ob_get_clean();

        // Create an instance of the Dompdf class
        $dompdf = new Dompdf();

        // Load HTML content into Dompdf
        $dompdf->loadHtml($htmlContent);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream($outputFilename);
    }
}
