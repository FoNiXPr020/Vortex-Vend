<?php

namespace App\Controllers\Community;

use Core\App;
use Core\Functions;

class CommunityController
{
    public function contact()
    {
        Functions::view('community/contact.view.php');
    }

    public function contactSubmit()
    {
        $functions = new Functions();
        $data = [
            'email' => $_POST['email'],
            'about' => $_POST['about'],
            'message' => $_POST['message']
        ];

        $path = BASE_TEMPLATE . 'contact.php';
		$email = $_ENV["APP_EMAIL"];
        $mail = App::SendEmail($path, $email, "Contact Us", $data);

        if( !$mail ) {
            $functions->error('email_address', "Failed to send email");
            return Functions::RedirectSession("/register", $data, $functions->errors());
        }

        $functions->success('contact', "Your message has been sent successfully");
        return Functions::RedirectSession("/contact", [], [], $functions->succeed());
    }
    public function helpCenter()
    {
        Functions::view('community/help-center.view.php');
    }
}
