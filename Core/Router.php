<?php

/**
 * Router - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

use Core\Middleware;

class Router
{
    protected static $routeParams = [];
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function middleware($key)
    {
        $this->routes[count($this->routes) - 1]['middleware'] = $key;

        return $this;
    }

    public static function getParam($paramName)
    {
        // Retrieve route parameters from the static property
        $routeParams = self::$routeParams;

        // Check if the requested parameter exists in the route parameters
        if (isset($routeParams[$paramName])) {
            return $routeParams[$paramName];
        }

        // Return null if the parameter doesn't exist
        return null;
    }

    public function Route($uri, $method)
    {
        // Normalize the URI to remove trailing slash
        $uri = rtrim($uri, '/');
    
        foreach ($this->routes as $route) {
            // Normalize route URI
            $routeUri = rtrim($route['uri'], '/');
            
            // Check if the route matches the requested URI and method
            if ($this->isMatching($uri, $method, $routeUri, $route['method'])) {
    
                // Check if the route is for an API endpoint
                $isApi = strpos($uri, '/api/v1') === 0 && strpos($uri, '/api/v1/') !== false;
                
                // Perform CSRF validation for non-API routes
                if (!$isApi) {
                    Validation::performCsrfValidation($method);
                }
    
                // Resolve middleware
                if (isset($route['middleware'])) {
                    Middleware::resolve($route['middleware']);
                }
                
                // Extract route parameters
                self::$routeParams = $this->extractRouteParameters($uri, $routeUri);
    
                // Instantiate the controller and call the action
                list($controller, $action) = explode('@', $route['controller']);
                $controller = "App\\Controllers\\$controller";
                $controllerInstance = new $controller();
    
                if (method_exists($controllerInstance, $action)) {
                    return $controllerInstance->$action(...self::$routeParams);
                } else {
                    error_log("Method $action does not exist in controller $controller");
                    return $this->error(500); // Internal Server Error if method does not exist
                }
            }
        }
    
        $Url = App::getURI();
    
        // Handle API not found response
        if (strpos($uri, '/api/v1') === 0) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 404, 'message' => 'Not Found', 'uri' => $Url . $uri, 'method' => $method, 'info' => 'Read API documentation at ' . $Url . '/api/documentation']);
            exit();
        }
    
        // Default to 404 if no route matches
        return $this->error(); 
    }
    
    
    private function isMatching(string $requestedUri, string $requestedMethod, string $routeUri, string $routeMethod): bool
    {
        $requestedSegments = explode('/', $requestedUri);

        $routeSegments = explode('/', $routeUri);

        if (count($routeSegments) !== count($requestedSegments)) {
            return false;
        }

        foreach ($routeSegments as $index => $segment) {
            // If the segment is dynamic, store the parameter value
            if (strpos($segment, '{') !== false) {
                self::$routeParams[trim($segment, '{}')] = $requestedSegments[$index];
            } elseif ($segment !== $requestedSegments[$index]) {
                return false;
            }
        }

        return $routeMethod === $requestedMethod;
    }

    protected function extractRouteParameters(string $requestUri, string $routeUri): array
    {
        $parameters = [];
        $routeSegments = explode('/', $routeUri);
        $requestSegments = explode('/', $requestUri);

        foreach ($routeSegments as $index => $segment) {
            if (strpos($segment, '{') !== false) {
                $parameters[trim($segment, '{}')] = $requestSegments[$index] ?? null;
            }
        }

        return $parameters;
    }

    public static function error($code = 404)
    {
        http_response_code($code);
        require Functions::base_path("views/{$code}.view.php");
        die();
    }
}
