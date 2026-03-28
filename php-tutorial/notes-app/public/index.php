<?php

const BASE_PATH = __DIR__.'/../';

require BASE_PATH.'Core/functions.php';

require BASE_PATH . 'vendor/autoload.php';  
session_start();

// spl_autoload_register(function ($class) {
//     // Core\Database
//     $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

//     require base_path("/{$class}.php");
// });

require base_path('bootstrap.php');

$router = new Core\Router();

$routes = require base_path("routes.php");

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// qui sto dicendo: se esiste un parametro _method in POST, usalo come metodo HTTP
// altrimenti, usa il metodo HTTP della richiesta
// questo è utile per supportare metodi HTTP come PUT e DELETE che non sono supportati dai form HTML
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);