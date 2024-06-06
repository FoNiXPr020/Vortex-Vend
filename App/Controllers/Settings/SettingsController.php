<?php

namespace App\Controllers\Settings;

use Core\Database;
use Core\Functions;
use Core\Session;
use Core\Validation;
use Core\App;


class SettingsController
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
        //Functions::dd($_SESSION['user']);
        $user = App::getUser();

        Functions::view("account/account.view.php", [
            'data' => Session::get('data'),
            'user' => $user
        ]);
    }

    public function update()
    {
        $user = App::getUser();
        $data = [
            'current_password' => $_POST['current_password'],
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password']
        ];

        // Validation
        switch (true) {
            case $data['password'] != $data['confirm_password']:
                $this->functions->error('password', "Passwords do not match.");
                return Functions::RedirectSession("/account", [], $this->functions->errors());
                break;
            case !Validation::verifyPassword($data['current_password'], $user['password']):
                $this->functions->error('password', "Current password is incorrect.");
                return Functions::RedirectSession("/account", [], $this->functions->errors());
                break;
            case $data['password'] == $data['current_password']:
                $this->functions->error('password', "New password cannot be the same as the old password.");
                return Functions::RedirectSession("/account", [], $this->functions->errors());
                break;
            case strlen($data['password']) < 6:
                $this->functions->error('password', "Password must be at least 6 characters long.");
                return Functions::RedirectSession("/account", [], $this->functions->errors());
                break;
        }

        // Update password
        $hashedPassword = Validation::secureHash($data['password']);

        $result = $this->database->Query("UPDATE users SET password = ? WHERE id = ?", [$hashedPassword, $user['user_id']], "UPDATE");

        if (!$result) {
            $this->functions->error('password', "Failed to update password.");
            return Functions::RedirectSession("/account", [], $this->functions->errors());
        }

        $user['password'] = $hashedPassword;
        App::setUser('user', $user);
        $this->functions->success('password', "Password updated successfully.");
        return Functions::RedirectSession("/account", [], [], $this->functions->succeed());
    }
}
