<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        $lifetime = (int) ($_ENV['SESSION_LIFETIME'] ?? 7200);
        $base = app_base_path();
        $cookiePath = $base === '' ? '/' : $base . '/';

        session_name('uca_tracker');
        session_set_cookie_params([
            'lifetime' => $lifetime,
            'path' => $cookiePath,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }

    public static function flash(string $type, string $message): void
    {
        self::start();
        $_SESSION['_flash'][] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    /** @return list<array{type: string, message: string}> */
    public static function pullFlash(): array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return [];
        }

        $messages = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return is_array($messages) ? $messages : [];
    }
}
