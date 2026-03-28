<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{
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
        $this->add('GET', $uri, $controller);
        return $this;
    }

    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
        return $this;
    }

    public function delete($uri, $controller)
    {
        $this->add('DELETE', $uri, $controller);
        return $this;
    }

    public function patch($uri, $controller)
    {
        $this->add('PATCH', $uri, $controller);
        return $this;
    }

    public function put($uri, $controller)
    {
        $this->add('PUT', $uri, $controller);
        return $this;
    }

    public function middleware($middleware)
    {
        // Applica il middleware all'ultima rotta aggiunta
        $lastIndex = count($this->routes) - 1;
        $this->routes[$lastIndex]['middleware'] = $middleware;
        return $this;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                Middleware::resolve($route['middleware']);
                return require base_path('Http/controllers/' . $route['controller']);            }
        }
        

        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }
}
// dd(parse_url($_SERVER['REQUEST_URI'])['path']);

// $routes = require base_path("routes.php");

// // ---- Include la pagina corretta ----
// $page = resolve_route($routes);
// include $page; 
