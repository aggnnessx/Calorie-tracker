<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

if (PHP_SAPI === 'cli-server') {
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $file = __DIR__ . $requestPath;
    if ($requestPath !== '/' && is_file($file)) {
        return false;
    }
}

require ROOT_PATH . '/app/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Core\Router;

$router = new Router();
$pages = new PageController();
$auth = new AuthController();

$router->get('/', [$pages, 'home']);
$router->get('/diary', [$pages, 'diary']);
$router->get('/goals', [$pages, 'goals']);
$router->get('/weight', [$pages, 'weight']);

$router->get('/login', [$auth, 'login']);
$router->post('/login', [$auth, 'login']);
$router->get('/register', [$auth, 'register']);
$router->post('/register', [$auth, 'register']);

$router->dispatch();
