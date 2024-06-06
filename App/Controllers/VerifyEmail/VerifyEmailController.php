<?php

namespace App\Controllers\VerifyEmail;

use Core\Database;
use Core\Functions;
use Core\Session;
use Core\Validation;
use Core\App;

class VerifyEmailController
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
        
        Functions::view("account/verify.view.php", [
            'data' => Session::get('data'),
            'user' => $user
        ]);
    }

    public function confirm()
    {
        $user = App::getUser();
        $data = [
            "verification_code" => $_POST['verification_code']
        ];

        switch (true) {
            case empty($data['verification_code']):
                $this->functions->error('verification_code', "Verification code is required");
                return Functions::RedirectSession("/verification", [], $this->functions->errors());
                break;

            case !Validation::Number($data['verification_code']):
                $this->functions->error('verification_code', "Verification code must be a number");
                return Functions::RedirectSession("/verification", [], $this->functions->errors());
                break;
        }

        $check = $this->database->Query("SELECT email_address FROM email_verification WHERE verification_code = ? AND email_address = ?", [$data['verification_code'], $user['email_address']], "SELECT");

        if (!$check) {
            $this->functions->error('verification_code', "Invalid verification code");
            return Functions::RedirectSession("/verification", [], $this->functions->errors());
        }

        $this->database->Query("UPDATE users SET verified = 1 WHERE email_address = ?", [$user['email_address']], "UPDATE");
        $this->database->Query("DELETE FROM email_verification WHERE email_address = ?", [$user['email_address']], "DELETE");

        $user['verified'] = 1;
        App::setUser('user', $user);

        $this->functions->success('email_address', "Thank you, Your Account verified successfully");
        return Functions::RedirectSession("/account", [], [], $this->functions->succeed());
    }

    public function verifyEmail()
    {
        $user = App::getUser();
        $email = $user['email_address'];
        $verification_code = mt_rand(10000000, 99999999);
        $subject = "Email Verification";
        $path = BASE_TEMPLATE . 'email_verification.php';
    
        // Check if there is an existing verification request
        $sql = "SELECT * FROM email_verification WHERE email_address = ?";
        $check = $this->database->Query($sql, [$email], "SELECT")[0] ?? null;
    
        if (empty($check)) {
            // Insert new verification request
            $this->database->Query("INSERT INTO email_verification (email_address, verification_code, created_at) VALUES (?, ?, NOW())", [$email, $verification_code], "INSERT");
    
            // Send verification email
            App::SendEmail($path, $email, $subject, ['verification_code' => $verification_code]);
    
            $this->functions->success('success', 'Email verification code successfully sent to your email');
            return Functions::RedirectSession("/verification", [], [], $this->functions->succeed());
        } else {
            // Check the time difference between the current time and the last request
            $created_at = strtotime($check['created_at']);
            $current_time = time();
            $time_difference = $current_time - $created_at;
            $time_limit_seconds = 5 * 900;

            if ($time_difference >= $time_limit_seconds) {
                // Update existing verification request
                $this->database->Query("UPDATE email_verification SET verification_code = ?, created_at = NOW(), updated_at = NOW() WHERE email_address = ?", [$verification_code, $email], "UPDATE");
    
                // Send verification email
                App::SendEmail($path, $email, $subject, ['verification_code' => $verification_code]);
    
                $this->functions->success('success', 'Email verification code successfully sent to your email');
                return Functions::RedirectSession("/verification", [], [], $this->functions->succeed());
            } else {
                // Return an error indicating that the user needs to wait before requesting a new code
                $this->functions->error('code', 'Please wait 5 minutes before requesting a new code');
                return Functions::RedirectSession("/verification", [], $this->functions->errors());
            }
        }
    }
    
}
