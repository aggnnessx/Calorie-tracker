<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Services\AuthService;
use App\Core\Session;

final class AuthMiddleware
{
    public static function handle(): void
    {
        if (AuthService::check()) {
            return;
        }

        Session::flash('error', 'Please sign in to continue.');
        $_SESSION['_intended'] = app_request_path();
        redirect('/login');
    }

    public static function wrap(callable $handler): callable
    {
        return static function () use ($handler): void {
            self::handle();
            $handler();
        };
    }
}
