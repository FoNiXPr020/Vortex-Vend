<?php

namespace App\Controllers\Register;

use Core\Database;
use Core\Functions;
use Core\Session;
use Core\Validation;
use Core\App;
use Core\Auth;
use Core\Translator;
use Google\Client;

class RegisterController
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
        Functions::view("register/register.view.php", [
            'data' => Session::get('data'),
        ]);
    }

    public function Register()
    {
        // Retrieve form data
        $table = "users";
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'username' => $_POST['username'],
            'email_address' => $_POST['email_address'],
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password']
        ];

        // Check if passwords match
        if ($data['password'] !== $data['confirm_password']) {
            $this->errors->error('confirm_password', "Passwords don't match");
            return Functions::RedirectSession("/register", $data, $this->errors->errors());
        }

        // Validate input data using switch 
        switch (true) {
            case !Validation::SpecialCharacter($data['username']):
                $this->errors->error('username', "Username must not contain special characters");
                return Functions::RedirectSession("/register", $data, $this->errors->errors());
                break;
            case !Validation::Alpha($data['first_name'], 2, 15):
                $this->errors->error('first_name', "First name must be between 2 and 15 letters characters");
                return Functions::RedirectSession("/register", $data, $this->errors->errors());
                break;

            case !Validation::Alpha($data['last_name'], 2, 15):
                $this->errors->error('last_name', "Last name must be between 2 and 15 letters characters");
                return Functions::RedirectSession("/register", $data, $this->errors->errors());
                break;

            case !Validation::String($data['username'], 6, 20):
                $this->errors->error('username', "Username must be between 6 and 20 characters");
                return Functions::RedirectSession("/register", $data, $this->errors->errors());
                break;

            case !Validation::Email($data['email_address']):
                $this->errors->error('email_address', "Invalid email address");
                return Functions::RedirectSession("/register", $data, $this->errors->errors());
                break;
        }

        // Check if username already exists
        $existingUsername = $this->database->Exists($table, "username", $data['username']);
        $existingEmail = $this->database->Exists($table, "email_address", $data['email_address']);

        if ($existingUsername) {
            $this->errors->error('username', Translator::Translate("Username already exists"));
            return Functions::RedirectSession("/register", $data, $this->errors->errors());
        }

        if ($existingEmail) {
            $this->errors->error('email_address', Translator::Translate("Email already exists"));
            return Functions::RedirectSession("/register", $data, $this->errors->errors());
        }

        $requirements = Validation::checkPasswordRequirements($data['password']);
        if (!empty($requirements)) {
            // Escape error messages and replace <br> with newline characters

            $errorMessage = implode("<br>", $requirements);

            $this->errors->error('password', $errorMessage);

            return Functions::RedirectSession("/register", $data, $this->errors->errors());
        }

        // Securely hash the password before storing
        $hashedPassword = Validation::secureHash($data['password']);

        $user_id = $this->database->insert($table, [
            'auth_id' => null,
            'username' => $data['username'],
            'email_address' => $data['email_address'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => $hashedPassword,
            'role' => 'guest',
            'phone_number' => null,
            'address' => null,
            'age' => null,
            'verified' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'profile_img' => null,
            'profile_bio' => "Vortex Vend is a platform where you can sell and buy products",
        ], true);

        $login = [
            'user_id' => $user_id,
            'auth_id' => null,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email_address' => $data['email_address'],
            'password' => $hashedPassword,
            'role' => 'guest',
            'phone_number' => null,
            'address' => null,
            'age' => null,
            'verified' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'profile_img' => null,
            'profile_bio' => "Vortex Vend is a platform where you can sell and buy products",
            'status' => 0,
            'customers_status' => 0,
            'followers_status' => 0,
            'following_status' => 0
        ];

        Auth::GenerateJWT($user_id, $data['email_address']);
        Session::login($login);

        // Redirect to the homepage or a success page
        return Functions::Redirect("/{$data['username']}");
    }

    public function GoogleRegister()
    {
        $table = "users";

        if (!isset($_POST['g_csrf_token']) && !isset($_POST['credential']) && empty($_POST['g_csrf_token']) && empty($_POST['credential']))
            return Functions::redirect('/register?error=invalid_toke');

        if ($_POST['g_csrf_token'] !== $_COOKIE['g_csrf_token'])
            return Functions::redirect('/register?error=invalid_toke');

        $client = new Client(['client_id' => $_ENV['GOOGLE_CLIENT_ID']]);

        try {
            $payload = $client->verifyIdToken($_POST['credential']);
        } catch (\Exception $e) {
            return Functions::redirect('/register?error=invalid_token');
        }

        $email = $payload['email'];
        $username = $payload['given_name'] . Validation::randomUsername(5);
        $password = Validation::randomPassword();
        $hashedPassword = Validation::secureHash($password);
        $verfied = $payload['email_verified'] ? '1' : '0';

        $user = $this->database->Query("SELECT email_address FROM $table WHERE email_address = ?", [$email], "SELECT")[0];

        if ($user) {
            $this->errors->error('email', "Email address already registered in our records. Please <a class='text-danger text-decoration-none' href='/login'><b>Login here</b></a>");
            return Functions::RedirectSession("/register", [], $this->errors->errors());
        }

        $filename = explode("=", $payload['picture'])[0];

        $uploaded_success = App::downloadImage($filename, "assets/uploads/profiles");

        $profile_img = App::getURI() .'/'. $uploaded_success;

        $user_id = $this->database->insert($table, [
            'auth_id' => $payload['sub'],
            'username' => $username,
            'email_address' => $email,
            'first_name' => $payload['given_name'] ?? null,
            'last_name' => $payload['family_name'] ?? null,
            'password' => $hashedPassword,
            'verified' => $verfied,
            'profile_img' => $profile_img,
            'profile_bio' => "Vortex Vend is a platform where you can sell and buy products",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'role' => 'guest',
            'phone_number' => null,
            'address' => null,
            'age' => null,
            'status' => 0,
            'customers_status' => 0,
            'followers_status' => 0,
            'following_status' => 0
        ], true);

        $register = [
            'user_id' => $user_id,
            'auth_id' => $payload['sub'],
            'first_name' => $payload['given_name'] ?? null,
            'last_name' => $payload['family_name'] ?? null,
            'username' => $username,
            'email_address' => $email,
            'password' => $hashedPassword,
            'role' => 'guest',
            'phone_number' => null,
            'address' => null,
            'age' => null,
            'verified' => $verfied,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'profile_img' => $profile_img,
            'profile_bio' => "Vortex Vend is a platform where you can sell and buy products",
            'status' => 0,
            'customers_status' => 0,
            'followers_status' => 0,
            'following_status' => 0
        ];

        Auth::GenerateJWT($user_id, $email);
        Session::login($register);

        // Password is valid, RedirectSession to homepage
        return Functions::Redirect("/{$username}");
    }
}
