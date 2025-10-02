<?php
// src/public/index.php

$routes = include '../config/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = '/proyecto/clinica-app/src/public';
if (strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}

if (array_key_exists($uri, $routes)) {
    include $routes[$uri];
} else {
    http_response_code(404);
    include '../app/Views/404.php';
}