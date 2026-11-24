<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['REQUEST_METHOD'] = 'GET';

require ROOT_PATH . '/app/bootstrap.php';

use App\Controllers\AuthController;
use App\Core\Router;

$router = new Router();
$auth = new AuthController();
$router->get('/login', [$auth, 'login']);
$router->get('/register', [$auth, 'register']);

ob_start();
$router->dispatch('GET', '/login');
$login = (string) ob_get_clean();

ob_start();
$router->dispatch('GET', '/register');
$register = (string) ob_get_clean();

function assert_contains(string $haystack, string $needle, string $label): void
{
    if (!str_contains($haystack, $needle)) {
        fwrite(STDERR, "FAIL {$label}: missing {$needle}\n");
        exit(1);
    }
    echo "PASS {$label}\n";
}

assert_contains($login, 'Sign in', 'login heading');
assert_contains($login, 'name="email"', 'login email field');
assert_contains($login, 'name="password"', 'login password field');
assert_contains($login, 'action="' . url('/login') . '"', 'login posts through router');
assert_contains($login, url('/register'), 'login links to register');

assert_contains($register, 'Create account', 'register heading');
assert_contains($register, 'name="full_name"', 'register name field');
assert_contains($register, 'name="email"', 'register email field');
assert_contains($register, 'name="password"', 'register password field');
assert_contains($register, 'action="' . url('/register') . '"', 'register posts through router');
assert_contains($register, url('/login'), 'register links to login');

echo "All page checks passed\n";
