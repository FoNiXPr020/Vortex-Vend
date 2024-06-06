<?php

/**
 * Functions - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

use Dotenv\Dotenv;

const BASE_PATH = __DIR__ . "/../";

class Functions
{
	protected $errors = [];
	protected $success = [];

	public function __construct()
	{
		// Load environment variables from .env file
		$dotenv = Dotenv::createImmutable(BASE_PATH);
		$dotenv->load();
	}

	public static function dd($value)
	{
		echo '<pre>';
		var_dump($value);
		echo '</pre>';

		die();
	}

	public function error($field, $message)
	{
		$this->errors[$field] = $message;

		return $this;
	}

	public function errors()
	{
		return $this->errors;
	}

	public function success($field, $message)
	{
		$this->success[$field] = $message;

		return $this;
	}

	public function succeed()
	{
		return $this->success;
	}

	public static function urlIs($value)
	{
		return $_SERVER['REQUEST_URI'] == $value;
	}

	public static function base_path($path)
	{
		return BASE_PATH . $path;
	}

	public static function previousUrl()
	{
		return $_SERVER['HTTP_REFERER'] ?? null;
	}

	public static function view($path, $attributes = [])
	{
		$base_path = self::base_path('views/' . $path);

		// Sanitize attributes to prevent XSS attacks
		$sanitizedAttributes = self::sanitizeArray($attributes);

		extract($sanitizedAttributes);

		// Get errors from session
		$errors = Session::get("errors");
		$success = Session::get("success");

		require $base_path;
	}

	// Recursive function to sanitize array values
	public static function sanitizeArray($array)
	{
		$sanitizedArray = [];
		foreach ($array as $key => $value) {
			if (is_string($value)) {
				$sanitizedArray[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
			} elseif (is_array($value)) {
				$sanitizedArray[$key] = self::sanitizeArray($value);
			} else {
				$sanitizedArray[$key] = $value;
			}
		}
		return $sanitizedArray;
	}

	public static function RedirectSession(string $route, array $data = [], array $errors = [], array $success = [])
	{
		Session::flash('errors', $errors);
		Session::flash('success', $success);
		Session::flash('data', $data);
		self::Redirect($route);
	}

	public static function Redirect(string $path)
	{
		header("Location: {$path}");
		exit();
	}
}
