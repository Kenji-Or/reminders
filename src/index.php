<?php
require_once 'Router/Router.php';
require_once 'Router/Route.php';
require_once 'Router/RouterException.php';
require_once 'db.php';

$url = $_GET['url'] ?? '/';
$router = new Router($url);


// Définition des routes
$router->get('/', function() {
    echo "Bienvenue sur la page d'accueil!";
});

try {
    $router->run();
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
}