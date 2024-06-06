<?php

namespace App\Controllers\Login;

use Core\Database;
use Core\Functions;
use Core\Session;
use Core\Validation;
use Google\Client;
use Core\Auth;
use Core\App;

class LoginController
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
        Functions::view("login/login.view.php", [
            'data' => Session::get('data')
        ]);
    }

    public function Login() {
        $table = "users";
        $data = ["email_address" => $_POST['email_address'], "password" => $_POST['password']];
        $email = $data['email_address'];
        // Check if email is valid and exists in records model.
        if (!Validation::email($data['email_address']) || !$this->database->Exists($table, "email_address", $email)) {
            $this->errors->error('email', "Please enter a valid email address.");
            return Functions::RedirectSession("/login", $data, $this->errors->errors());
        }
        // Get user information from records model based on email.
        $info = $this->database->Select($table, "*", "email_address = ?", [$email]);
        // Check if maximum login attempts has been reached.
        if (Session::get('login_attempts') >= $_ENV['MAX_LOGIN_ATTEMPTS'] && !Validation::verifyPassword($data['password'], $info['password'])) {
            Session::put('login_attempts', 0);
            $this->errors->error('password', "Incorrect password. Please try to reset your password.");
            return Functions::RedirectSession("/forgot-password", $data = ["email_address" => $email], $this->errors->errors());
        }
        // Check if password is correct.
        if (!Validation::verifyPassword($data['password'], $info['password'])) {
            Session::put('login_attempts', Session::get('login_attempts') + 1);
            $this->errors->error('password', "Incorrect password. Please try again.");
            return Functions::RedirectSession("/login", $data, $this->errors->errors());
        }
        // Login successful. Start session. generate JWT.
        $login = App::SessionLogin($info);
        Auth::GenerateJWT($info['id'], $info['email_address']);
        Session::login($login);
        // Redirect to user profile.
        return Functions::Redirect("/{$info['username']}");
    }

    public function GoogleLogin()
    {
        if (!isset($_POST['g_csrf_token']) && !isset($_POST['credential']) && empty($_POST['g_csrf_token']) && empty($_POST['credential']))
            return Functions::redirect('/login');

        if ($_POST['g_csrf_token'] !== $_COOKIE['g_csrf_token'])
            return Functions::redirect('/login');

        $client = new Client(['client_id' => $_ENV['GOOGLE_CLIENT_ID']]);

        try {
            $payload = $client->verifyIdToken($_POST['credential']);
        } catch (\Exception $e) {
            return Functions::redirect('/login?error=invalid_token');
        }

        $email = $payload['email'];

        $table = "users";
        $user = $this->database->Query("SELECT * FROM $table WHERE email_address = ?", [$email], "SELECT")[0];

        if (!$user) {
            $this->errors->error('email', "Email address not registered in our records. Please register an account.");
            return Functions::RedirectSession("/login", [], $this->errors->errors());
        }

        $login = App::SessionLogin($user);
        Auth::GenerateJWT($user['id'], $user['email_address']);
        Session::login($login);

        return Functions::Redirect("/{$user['username']}");
    }
}
