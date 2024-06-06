<?php

/**
 * Auth - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    public static function AuthJWT()
    {

        $key = $_ENV['JWT_SECRET_KEY'];
        $jwt = isset($_SESSION['jwt']) ? $_SESSION['jwt'] : '';

        if (empty($jwt)) {
            Functions::redirect('/logout');
            exit();
        }

        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            // Check if JWT has expired
            $current_time = time();

            if ($current_time > $decoded->exp) {
                Functions::redirect('/logout');
            }
        } catch (ExpiredException $e) {
            Functions::redirect('/logout');
        } catch (\Exception $e) {
            Functions::redirect('/logout');
        }
    }

    public static function GenerateJWT( $user_id, $email )
    {
        // Generate JWT
        $key = $_ENV['JWT_SECRET_KEY'];
        $payload = [
            'iss' => 'http://localhost',
            'aud' => 'http://localhost',
            'iat' => time(),
            'exp' => time() + (60 * 60), // Token valid for 1 hour or do ( 60 * 1 for 1 minute testing )
            'sub' => $user_id,
            'email' => $email,
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        // Save JWT in session
        return $_SESSION['jwt'] = $jwt;
    }
}
