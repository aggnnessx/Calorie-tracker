<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

final class AuthController
{
    public function login(): void
    {
        View::render('auth/login.php', [
            'title' => 'Sign in',
            'currentNav' => 'login',
            'errors' => [],
            'old' => [
                'email' => '',
            ],
        ]);
    }

    public function register(): void
    {
        View::render('auth/register.php', [
            'title' => 'Create account',
            'currentNav' => 'register',
            'errors' => [],
            'old' => [
                'full_name' => '',
                'email' => '',
            ],
        ]);
    }
}
