<?php

/**
 * Validation - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

class Validation
{
    // Function to escape HTML special characters in a string
    public static function EscapeString($string)
    {
        if (is_array($string)) {
            return array_map([self::class, 'EscapeString'], $string);
        }
        
        if ($string === null) {
            return '';
        }

        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public static function EscapeArray(array $array)
    {
        return array_map([self::class, 'EscapeString'], $array);
    }

    public static function String($value, $min = 1, $max = INF)
    {
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function Integer($value)
    {
        $value = trim($value);

        return filter_var($value, FILTER_VALIDATE_INT);
    }

    public static function SpecialCharacter($value)
    {
        $value = trim($value);

        return ctype_alnum($value);
    }

    // letters only and between 2 and 15 characters
    public static function Alpha($value)
    {
        $value = trim($value);

        return ctype_alpha($value) && strlen($value) >= 2 && strlen($value) <= 15;
    }

    public static function Number($value)
    {
        $value = trim($value);

        return is_numeric($value);
    }

    public static function Email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function greaterThan(int $value, int $greaterThan): bool
    {
        return $value > $greaterThan;
    }

    public static function strongPassword(string $password): bool
    {
        // Password must be at least 8 characters long.
        // and contain at least one uppercase letter, one lowercase letter,
        // one number, and one special character.
        $requirements = static::checkPasswordRequirements($password);
        return empty($requirements);
    }

    public static function secureHash(string $password): string
    {
        // Use bcrypt for secure password hashing
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyPassword(string $password, string $hashedPassword): bool
    {
        // Verify a password against its hashed version
        return password_verify($password, $hashedPassword);
    }

    public static function checkPasswordRequirements(string $password): array
    {
        $violations = [];

        switch (true) {
            case strlen($password) < 8:
                $violations[] = 'Password must be at least 8 characters long.';

            case !preg_match('/[a-z]/', $password):
                $violations[] = 'Password must contain at least one lowercase letter.';

            case !preg_match('/\d/', $password):
                $violations[] = 'Password must contain at least one digit.';
        }

        return $violations;
    }

    public static function randomPassword($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomPassword;
    }

    public static function randomUsername($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomUsername = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomUsername .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomUsername;
    }

    public static function checkInputRequirements(array $inputData, array $validationRules): array
    {
        $violations = [];
    
        foreach ($validationRules as $rule) {
            // Ensure all required fields are present in the rule
            if (!isset($rule['field'], $rule['minLength'], $rule['maxLength'], $rule['errorMessage'])) {
                throw new \InvalidArgumentException("Invalid validation rule format.");
            }
    
            $field = $rule['field'];
            $value = $inputData[$field] ?? null;
            $minLength = $rule['minLength'];
            $maxLength = $rule['maxLength'];
            $errorMessage = $rule['errorMessage'];
    
            // Perform validation based on field type
            switch ($field) {
                case 'email_address':
                    if (!self::Email($value)) {
                        $violations[$field] = $errorMessage;
                    }
                    break;
                default:
                    if (!self::String($value, $minLength, $maxLength)) {
                        $violations[$field] = $errorMessage;
                    }
                    break;
            }
        }
    
        return $violations;
    }
    

    public static function performCsrfValidation($method)
    {
        // Skip CSRF validation for Google POST requests
        if ( $method === 'POST' && (isset($_POST['g_csrf_token']) && isset($_POST['credential'])) ) {
            return;
        }

        // Perform CSRF token validation for all methods except GET
        if (strtoupper($method) !== 'GET' && !self::validateCsrfToken()) {
            // If CSRF token validation fails, redirect back
            $previousPage = Functions::previousUrl() ?? '/';
            $errors = ['csrf' => 'Something went wrong. It seems like the security method is not valid. Please try again.'];
            Session::flash('errors', $errors);
            Functions::Redirect($previousPage);
        }
    }

    public static function setMethod($method = "POST")
	{
		// Echoing a hidden input field with the specified method
		echo '<input type="hidden" name="' . $_ENV['METHOD'] . '" value="' . $method . '">';
	}

	public static function generateCsrfToken()
	{
		$csrfTokenKey = $_ENV['CSRF_TOKEN'];
		if (!Session::has($csrfTokenKey)) {
			Session::put($csrfTokenKey, bin2hex(random_bytes(32)));
		}
		echo '<input type="hidden" name="' . $csrfTokenKey . '" value="' . Session::get($csrfTokenKey) . '">';
	}

	public static function validateCsrfToken()
	{
		$csrfTokenKey = $_ENV['CSRF_TOKEN'];
		if (
			isset($_POST[$csrfTokenKey]) &&
			Session::has($csrfTokenKey) &&
			$_POST[$csrfTokenKey] === Session::get($csrfTokenKey)
		) {
			return true;
		}
		return false;
	}

    public static function RandomBin2hex( $length = 32 )
    {
        return bin2hex(random_bytes($length));
    }
}
