<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Services\AuthService;

final class DashboardController
{
    public function show(): void
    {
        View::render('dashboard.php', [
            'title' => 'Dashboard',
            'currentNav' => 'dashboard',
            'user' => AuthService::user(),
        ]);
    }

    public function admin(): void
    {
        View::render('placeholder.php', [
            'title' => 'Admin',
            'currentNav' => '',
            'heading' => 'Admin',
            'message' => 'Staff tools for the menu and food catalog will go here.',
        ]);
    }
}
