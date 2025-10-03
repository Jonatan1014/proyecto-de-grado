<?php
// src/public/index.php

require_once '/var/www/html/src/bootstrap.php';

require_once CONFIG_PATH . '/config.php';
require_once CONFIG_PATH . '/database.php';

$routes = include CONFIG_PATH . '/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Eliminar el prefijo base si es necesario
$base = '/proyecto-de-grado/src/public';
if (strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}

if (array_key_exists($uri, $routes)) {
    $route = $routes[$uri];

    // Si es un array, es un controlador
    if (is_array($route)) {
        $controllerName = $route['controller'];
        $action = $route['action'];

        // Incluir el controlador
        $controllerFile = APP_PATH . "/Controllers/{$controllerName}.php";
        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            // Instanciar y llamar al método
            $controller = new $controllerName();
            $controller->$action();
        } else {
            http_response_code(404);
            include VIEWS_PATH . '/404.php';
        }
    } else {
        // Si es una vista directa
        include BASE_PATH . $route;
    }
} else {
    http_response_code(404);
    include VIEWS_PATH . '/404.php';
}