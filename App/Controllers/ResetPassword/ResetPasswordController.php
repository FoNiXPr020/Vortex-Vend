<?php

namespace App\Controllers\ResetPassword;

use Core\Database;
use Core\Functions;
use Core\Session;
use Core\Validation;
use Core\App;

class ResetPasswordController
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
        Functions::view("reset_password/reset_password.view.php", [
            'data' => Session::get('data'),
        ]);
    }

    function sendReset()
    {
        $table = "users";
        $data = [
            'email_address' => $_POST['email_address'],
        ];

        $existingEmail = $this->database->Exists($table, "email_address", $data['email_address']);

        switch (true) {
            case empty($data['email_address']):
                $this->errors->error('email_address', "Email is required");
                return Functions::RedirectSession("/forgot-password", $data, $this->errors->errors());
                break;

            case !filter_var($data['email_address'], FILTER_VALIDATE_EMAIL):
                $this->errors->error('email_address', "Invalid email address");
                return Functions::RedirectSession("/forgot-password", $data, $this->errors->errors());
                break;

            case !$existingEmail:
                $this->errors->error('email_address', "Email not found in our registrations");
                return Functions::RedirectSession("/forgot-password", $data, $this->errors->errors());
                break;
        }

        $table = "reset_password";
        $token = Validation::RandomBin2hex(64);
        $email = $this->database->Exists($table, 'email_address', $data['email_address']);

        if ($email)
            $this->database->Query("UPDATE $table SET verification_token = ? WHERE email_address = ?", [$token, $data['email_address']], "UPDATE");
        else
            $this->database->Query("INSERT INTO $table (email_address, verification_token) VALUES (?, ?)", [$data['email_address'], $token], "INSERT");

        $subject = "Password Reset";
        $path = BASE_TEMPLATE . 'password_reset.php';
        $mail = App::SendEmail($path, $data['email_address'], $subject, [ 'token' => $token] );

        if ($mail)
            $this->errors->success('success', 'Password reset link has been sent to <strong>' . $data['email_address'] . '</strong>.');
        return Functions::RedirectSession("/forgot-password", [], [], $this->errors->succeed());
    }

    public function verifyReset($token)
    {
        $check = $this->database->Exists('reset_password', 'verification_token', $token);

        if (!$check) {
            $this->errors->error('token', "Invalid token please try again");
            return Functions::RedirectSession("/forgot-password", [], $this->errors->errors());
        }

        Functions::view("reset_password/change_password.view.php", [
            'token' => $token
        ]);
    }

    public function confirmReset($token)
    {
        $data = [
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password']
        ];

        switch (true) {
            case empty($data['password']):
                $this->errors->error('password', "Password is required");
                return Functions::RedirectSession("/reset-password/{$token}", $data, $this->errors->errors());
                break;
            case empty($data['confirm_password']):
                $this->errors->error('confirm_password', "Confirm password is required");
                return Functions::RedirectSession("/reset-password/{$token}", $data, $this->errors->errors());
                break;

            case $data['password'] !== $data['confirm_password']:
                $this->errors->error('confirm_password', "Password does not match");
                return Functions::RedirectSession("/reset-password/{$token}", $data, $this->errors->errors());
                break;
        }

        $requirements = Validation::checkPasswordRequirements($data['password']);
        if (!empty($requirements)) {
            $errorMessage = implode("<br>", $requirements);
            $this->errors->error('password', $errorMessage);
            return Functions::RedirectSession("/reset-password/{$token}", $data, $this->errors->errors());
        }

        $table = "reset_password";
        $email = $this->database->Query("SELECT email_address FROM $table WHERE verification_token = ?", [$token], "SELECT")[0]['email_address'];

        if (!$email) {
            $this->errors->error('token', "Invalid token please try again");
            return Functions::RedirectSession("/forgot-password", [], $this->errors->errors());
        }

        $table = "users";
        $hashedPassword = Validation::secureHash($data['password']);
        $this->database->Query("UPDATE $table SET password = ? WHERE email_address = ?", [$hashedPassword, $email], "UPDATE");
        $this->database->Query("DELETE FROM reset_password WHERE verification_token = ?", [$token], "DELETE");

        $this->errors->success('success', 'Password has been changed successfully');
        return Functions::RedirectSession("/login", [], [], $this->errors->succeed());
    }
}
