<?php

declare(strict_types=1);

/**
 * Folder the app lives in, e.g. /uca-nutrition/public on Laragon,
 * or '' when the site is served from the public folder directly.
 */
function app_base_path(): string
{
    $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    $dir = dirname($scriptName);

    if ($dir === '/' || $dir === '\\' || $dir === '.') {
        return '';
    }

    return rtrim($dir, '/');
}

/** Link inside the app, e.g. url('/diary'). */
function url(string $path = '/'): string
{
    $base = app_base_path();
    $path = '/' . ltrim($path, '/');

    if ($path === '/') {
        return $base === '' ? '/' : $base . '/';
    }

    return $base . $path;
}

/** Escape text for HTML. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Hidden CSRF field for POST forms. */
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(\App\Core\Csrf::token()) . '">';
}

/** Send the browser to another app path and stop. */
function redirect(string $path, int $status = 302): never
{
    header('Location: ' . url($path), true, $status);
    exit;
}

/** Path used for routing, with the folder prefix removed. */
function app_request_path(): string
{
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $uri = str_replace('\\', '/', $uri);
    $base = app_base_path();

    if ($base !== '' && str_starts_with($uri, $base)) {
        $uri = substr($uri, strlen($base)) ?: '/';
    }

    if (str_ends_with($uri, '/index.php')) {
        $uri = substr($uri, 0, -strlen('/index.php')) ?: '/';
    }

    return rtrim($uri, '/') ?: '/';
}
