<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

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

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/') ?: '/';

$pages = [
    '/' => [
        'title' => 'Home',
        'currentNav' => 'menu',
        'view' => 'home.php',
    ],
    '/diary' => [
        'title' => 'Diary',
        'currentNav' => 'diary',
        'view' => 'placeholder.php',
        'heading' => 'Food diary',
        'message' => 'Breakfast, lunch, dinner, and snacks for the selected day will be logged here.',
    ],
    '/goals' => [
        'title' => 'Goals',
        'currentNav' => 'goals',
        'view' => 'placeholder.php',
        'heading' => 'Nutrition goals',
        'message' => 'Calorie and macro targets calculated from the student profile will show here.',
    ],
    '/weight' => [
        'title' => 'Weight',
        'currentNav' => 'weight',
        'view' => 'placeholder.php',
        'heading' => 'Weight log',
        'message' => 'One weigh-in per day will be recorded here.',
    ],
    '/login' => [
        'title' => 'Sign in',
        'currentNav' => '',
        'view' => 'placeholder.php',
        'heading' => 'Sign in',
        'message' => 'Student and admin sign-in will use this page.',
    ],
];

if (!isset($pages[$path])) {
    http_response_code(404);
    $title = 'Not found';
    $currentNav = '';
    $heading = 'Page not found';
    $message = 'That address is not part of the app yet.';
    ob_start();
    require ROOT_PATH . '/app/Views/placeholder.php';
    $content = ob_get_clean();
    require ROOT_PATH . '/app/Views/layouts/main.php';
    return;
}

$page = $pages[$path];
$title = $page['title'];
$currentNav = $page['currentNav'];
$heading = $page['heading'] ?? '';
$message = $page['message'] ?? '';

ob_start();
require ROOT_PATH . '/app/Views/' . $page['view'];
$content = ob_get_clean();

require ROOT_PATH . '/app/Views/layouts/main.php';
