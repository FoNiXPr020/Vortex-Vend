<?php

/**
 * Paypal - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

use Stripe\Price;

class Paypal
{
    public static function GetAccessToken()
    {
        $ch = curl_init();
        $base = PaypalBase();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $base . "/v1/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $_ENV["PP_CLIENT_ID"] . ":" . $_ENV["PP_CLIENT_SECRET"],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array("Content-Type: application/x-www-form-urlencoded"),
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response = json_decode($response, true)["access_token"];
    }

    public static function CreateOrder($accessToken, $productId, $price)
    {
        $ch = curl_init();
        $base = PaypalBase();
        $uri = App::getURI();

        $success_url = $uri . '/payment/success';
        $cancel_url = $uri . '/products/' . $productId;
        $lang = Translator::getSelectedLanguage();
        function Selectedlanguage( $lang )
        {
            switch ($lang) {
                case 'en':
                    return "en-US";
                    break;
                case 'fr':
                    return "fr-FR";
                    break;
                case 'ar':
                    return "en-AE";
                    break;
                case 'es':
                    return "es-ES";
                    break;
            }
        }

        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $accessToken
            ),
            CURLOPT_URL => $base . "/v2/checkout/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "custom_id" => $productId,
                        "amount" => [
                            "currency_code" => "EUR",
                            "value" => $price
                        ]
                    ]
                ],
                "payment_source" => [
                    "paypal" => [
                        "experience_context" => [
                            "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                            "landing_page" => "NO_PREFERENCE",
                            "brand_name" => "Vortex Vend",
                            "locale" => Selectedlanguage( $lang ),
                            "user_action" => "CONTINUE",
                            "return_url" => $success_url,
                            "cancel_url" => $cancel_url
                        ]
                    ]
                ]
            ]),
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        //return $response = json_decode($response, true)["links"][1]["href"];
        return $response = json_decode($response, true);
    }

    public static function CaptureOrder($accessToken, $orderId)
    {
        $ch = curl_init();
        $base = PaypalBase();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $base . "/v2/checkout/orders/{$orderId}/capture",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $accessToken,
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response = json_decode($response, true);
        // echo "<pre>";
        // print_r($response);
        // echo "</pre>";
    }

    public static function ShowOrder($accessToken, $orderId)
    {
        $ch = curl_init();
        $base = PaypalBase();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $base . "/v2/checkout/orders/{$orderId}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $accessToken,
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response = json_decode($response, true);
    }

    public static function GetOrder($accessToken, $orderId)
    {
        $ch = curl_init();
        $base = PaypalBase();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $base . "/v2/payments/captures/{$orderId}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $accessToken,
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response = json_decode($response, true);
    }
}
