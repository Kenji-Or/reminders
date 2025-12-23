<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/db.php';  // Inclusion de la connexion DB

use App\Router\Router;

$url = $_GET['url'] ?? '/';
$router = new Router($url);


// Définition des routes
$router->get('/', function() {
    echo "Bienvenue sur la page d'accueil!";
});

$router->get('/users', 'UserController@getAllUsers');

$router->get('/users/:id', 'UserController@getUserById');

$router->post('/user', 'UserController@createUser');

$router->post('/user/:id', 'UserController@updateUser');

$router->post('/user/:id/delete', 'UserController@deleteUser');

$router->post('/login', 'AuthController@loginUser');

$router->post('/logout', 'AuthController@logoutUser');

try {
    $router->run();
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
}