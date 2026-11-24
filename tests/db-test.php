<?php

// Stand-alone DB connection test. Usage (CLI): php tests/db-test.php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

// Simple .env loader
$envFile = ROOT_PATH . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$name, $value] = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value, " \t\"'");
    }
}

require ROOT_PATH . '/app/Core/Database.php';

$config = require ROOT_PATH . '/config/database.php';

echo "Connecting to {$config['host']}:{$config['port']}/{$config['dbname']} ...\n";

try {
    $pdo = \App\Core\Database::connect($config);
    $stmt = $pdo->query('SELECT 1 AS ok');
    $row = $stmt->fetch();

    if ($row && (int)$row['ok'] === 1) {
        echo "PASS: SELECT 1 returned 1\n";
        echo "PDO driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "\n";
        exit(0);
    }

    echo "FAIL: unexpected result\n";
    exit(1);
} catch (Throwable $e) {
    echo "FAIL: " . $e->getMessage() . "\n";
    exit(1);
}