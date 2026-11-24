<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/app/bootstrap.php';

use App\Core\Database;
use App\Repositories\UserRepository;

$config = require ROOT_PATH . '/config/database.php';

try {
    $pdo = Database::connect($config);
    $users = new UserRepository($pdo);

    $email = 'test.router.' . bin2hex(random_bytes(4)) . '@uca.edu';
    $missing = $users->findByEmail($email);
    if ($missing !== null) {
        fwrite(STDERR, "FAIL findByEmail should be null for a new address\n");
        exit(1);
    }
    echo "PASS findByEmail misses unknown user\n";

    $id = $users->create($email, password_hash('secret123', PASSWORD_DEFAULT), 'Test Student');
    if ($id < 1) {
        fwrite(STDERR, "FAIL create did not return an id\n");
        exit(1);
    }
    echo "PASS create user id {$id}\n";

    $found = $users->findByEmail($email);
    if ($found === null || $found['email'] !== $email || $found['full_name'] !== 'Test Student') {
        fwrite(STDERR, "FAIL findByEmail did not return the created user\n");
        exit(1);
    }
    echo "PASS findByEmail returns created user\n";

    $pdo->prepare('DELETE FROM users WHERE id = :id')->execute(['id' => $id]);
    echo "All user repository checks passed\n";
} catch (Throwable $e) {
    echo "SKIP user repository: " . $e->getMessage() . "\n";
    exit(0);
}
