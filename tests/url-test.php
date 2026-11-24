<?php

declare(strict_types=1);

require dirname(__DIR__) . '/app/helpers.php';

function assert_same(string $expected, string $actual, string $label): void
{
    if ($expected !== $actual) {
        fwrite(STDERR, "FAIL {$label}: expected {$expected}, got {$actual}\n");
        exit(1);
    }
    echo "PASS {$label}\n";
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = '/';
assert_same('', app_base_path(), 'root base');
assert_same('/', url('/'), 'root home url');
assert_same('/diary', url('/diary'), 'root diary url');
assert_same('/', app_request_path(), 'root path');

$_SERVER['SCRIPT_NAME'] = '/uca-nutrition/public/index.php';
$_SERVER['REQUEST_URI'] = '/uca-nutrition/public/';
assert_same('/uca-nutrition/public', app_base_path(), 'laragon base');
assert_same('/uca-nutrition/public/', url('/'), 'laragon home url');
assert_same('/uca-nutrition/public/diary', url('/diary'), 'laragon diary url');
assert_same('/uca-nutrition/public/assets/css/main.css', url('/assets/css/main.css'), 'laragon css url');
assert_same('/', app_request_path(), 'laragon home path');

$_SERVER['REQUEST_URI'] = '/uca-nutrition/public/index.php';
assert_same('/', app_request_path(), 'laragon index.php path');

$_SERVER['REQUEST_URI'] = '/uca-nutrition/public/diary';
assert_same('/diary', app_request_path(), 'laragon diary path');

echo "All URL helper checks passed\n";
