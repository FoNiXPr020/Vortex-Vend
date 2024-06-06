<?php

namespace App\Controllers;

use Core\Functions;
use Google\Client;
use Core\App;
use Core\Validation;

class NotesController
{
    public function index()
    {
        $product_id = 51;
        $token = '4454654645';
        $payer_id = '4454654645';
        $user = App::getUser();
        $app = new App();
        $product = $app->fetchProductByID($product_id);

        $path = BASE_TEMPLATE . "success_payment.php";
        $data = [
            'token' => $token,
            'payer_id' => $payer_id,
            'user' => $user,
            'product' => $product
        ];

        if (App::SendEmail($path, $user['email_address'], "Payment Successful", $data))
        {
             echo 'Email sent';
        }
        else
        {
            echo 'Email not sent';
        }
    }
    public function template()
    {
        include BASE_TEMPLATE . 'email_verification.php';
    }

    public function template2()
    {
        include BASE_TEMPLATE . 'password_reset.php';
    }

    public function template3()
    {
        include BASE_TEMPLATE . 'success_payment.php';
    }

    public function phpinfo()
    {
        phpinfo();
    }
}