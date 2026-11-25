<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
$_SERVER['SCRIPT_NAME'] = '/index.php';
require ROOT_PATH . '/app/bootstrap.php';

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Session;
use App\Repositories\UserRepository;
use App\Services\AuthService;

function assert_true(bool $ok, string $label): void
{
    if (!$ok) {
        fwrite(STDERR, "FAIL {$label}\n");
        exit(1);
    }
    echo "PASS {$label}\n";
}

Session::start();
Csrf::token();
assert_true(Csrf::check(Csrf::token()), 'csrf accepts session token');
assert_true(!Csrf::check('nope'), 'csrf rejects a bad token');

try {
    $pdo = Database::connect(require ROOT_PATH . '/config/database.php');
} catch (Throwable $e) {
    echo "SKIP auth service: " . $e->getMessage() . "\n";
    exit(0);
}

$users = new UserRepository($pdo);
$auth = new AuthService($users);
$email = 'day3.' . bin2hex(random_bytes(3)) . '@uca.edu';

$fail = $auth->register([
    'full_name' => 'Day Three',
    'email' => $email,
    'password' => 'short',
    'password_confirm' => 'short',
]);
assert_true(!$fail['ok'] && isset($fail['errors']['password']), 'register rejects a short password');

$created = $auth->register([
    'full_name' => 'Day Three',
    'email' => $email,
    'password' => 'secret123',
    'password_confirm' => 'secret123',
]);
assert_true($created['ok'], 'register succeeds');
assert_true(AuthService::check(), 'register signs the user in');

$row = $users->findByEmail($email);
assert_true(is_array($row) && str_starts_with((string) $row['password_hash'], '$2y$'), 'password is hashed');
assert_true(password_verify('secret123', (string) $row['password_hash']), 'hash matches the password');

AuthService::logout();
assert_true(!AuthService::check(), 'logout clears the session');

$bad = $auth->login(['email' => $email, 'password' => 'wrong-password']);
assert_true(!$bad['ok'], 'login rejects a wrong password');

$ok = $auth->login(['email' => $email, 'password' => 'secret123']);
assert_true($ok['ok'] && AuthService::check(), 'login accepts the real password');

$pdo->prepare('DELETE FROM users WHERE email = :email')->execute(['email' => $email]);
echo "All auth checks passed\n";
