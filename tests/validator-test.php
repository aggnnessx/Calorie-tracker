<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/app/bootstrap.php';

use App\Core\Validator;

function assert_true(bool $ok, string $label): void
{
    if (!$ok) {
        fwrite(STDERR, "FAIL {$label}\n");
        exit(1);
    }
    echo "PASS {$label}\n";
}

$empty = new Validator(['email' => '', 'password' => '']);
$empty->required('email')->required('password', 'Password')->email('email');
assert_true($empty->fails(), 'required fails on empty');
assert_true($empty->error('email') === 'Email is required.', 'required message');

$badEmail = new Validator(['email' => 'not-an-email']);
$badEmail->email('email');
assert_true($badEmail->error('email') === 'Enter a valid email address.', 'email format');

$short = new Validator(['password' => 'abc']);
$short->minLength('password', 8);
assert_true($short->error('password') === 'Must be at least 8 characters.', 'min length');

$range = new Validator(['height_cm' => '90']);
$range->range('height_cm', 100, 250);
assert_true($range->error('height_cm') === 'Must be between 100 and 250.', 'range');

$enum = new Validator(['role' => 'guest']);
$enum->enum('role', ['student', 'admin']);
assert_true($enum->error('role') === 'Choose a valid option.', 'enum');

$ok = new Validator([
    'email' => 'student@uca.edu',
    'password' => 'secret123',
    'height_cm' => '170',
    'role' => 'student',
]);
$ok->required('email')->email('email')->minLength('password', 8)->range('height_cm', 100, 250)->enum('role', ['student', 'admin']);
assert_true(!$ok->fails(), 'valid payload');

echo "All validator checks passed\n";
