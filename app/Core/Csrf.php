<?php

declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    public static function token(): string
    {
        Session::start();
        $token = $_SESSION['_csrf'] ?? '';
        if (!is_string($token) || $token === '') {
            $token = bin2hex(random_bytes(32));
            $_SESSION['_csrf'] = $token;
        }
        return $token;
    }

    public static function check(?string $token = null): bool
    {
        Session::start();
        $token ??= isset($_POST['_csrf']) ? (string) $_POST['_csrf'] : '';
        $expected = $_SESSION['_csrf'] ?? '';

        return is_string($expected)
            && $expected !== ''
            && hash_equals($expected, $token);
    }

    public static function verify(): void
    {
        $method = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
        if ($method !== 'POST') {
            return;
        }

        if (self::check()) {
            return;
        }

        http_response_code(419);
        Session::flash('error', 'Your form expired. Refresh the page and try again.');
        redirect(app_request_path());
    }
}
