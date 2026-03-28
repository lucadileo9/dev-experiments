<?php
use Core\Response;

function dd($value) {
    echo "<pre style='background:#111; color:#0f0; padding:15px; border-radius:8px; font-size:14px; line-height:1.4;'>";
    
    var_dump($value);
    echo "</pre>";
    die();
}

// ---- Router Function ----
function resolve_route($routes) {
    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    // Se la route esiste, torna il file
    if (array_key_exists($uri, $routes)) {
        return base_path($routes[$uri]);
    }
    else {
        abort(Response::NOT_FOUND);
    }
}

// ---- 404 Function ----
function abort($code) {
    http_response_code($code);
    require base_path("views/{$code}.php");
    die();
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    // Merge flash data with attributes
    $attributes = array_merge(\Core\Session::all(), $attributes);
    
    extract($attributes);

    require base_path('views/' . $path);
}

function redirect($path)
{
    header("Location: {$path}");
    die();
}

function old($key, $default = '')
{
    return Core\Session::get('old')[$key] ?? $default;
}
