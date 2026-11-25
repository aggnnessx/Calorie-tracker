<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\View;
use App\Services\AuthService;

final class AdminMiddleware
{
    public static function handle(): void
    {
        AuthMiddleware::handle();

        if (AuthService::isAdmin()) {
            return;
        }

        http_response_code(403);
        View::render('placeholder.php', [
            'title' => 'Admins only',
            'currentNav' => '',
            'heading' => 'Admins only',
            'message' => 'This screen is for cafeteria staff.',
        ]);
        exit;
    }

    public static function wrap(callable $handler): callable
    {
        return static function () use ($handler): void {
            self::handle();
            $handler();
        };
    }
}
