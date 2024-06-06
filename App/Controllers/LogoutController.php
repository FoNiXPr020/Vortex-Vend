<?php

namespace App\Controllers;

use Core\Functions;
use Core\Session;

class LogoutController
{
    public function index()
    {

        /* For multi language logout
        $lang = Session::get("lang");
        Session::destroy();
        Functions::Redirect("/?lang=" . $lang);*/

        Session::destroy();
        Functions::redirect('/login');
    }
}
