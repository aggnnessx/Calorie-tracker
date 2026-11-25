<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Services\AuthService;

final class AuthController
{
    public function showLogin(): void
    {
        $this->redirectIfSignedIn();
        $this->renderLogin();
    }

    public function login(): void
    {
        $this->redirectIfSignedIn();

        $result = AuthService::make()->login($_POST);
        if ($result['ok']) {
            Session::flash('success', 'Welcome back.');
            $intended = $_SESSION['_intended'] ?? '/dashboard';
            unset($_SESSION['_intended']);
            $path = is_string($intended) && str_starts_with($intended, '/') ? $intended : '/dashboard';
            redirect($path);
        }

        $this->renderLogin($result['errors'], $result['old']);
    }

    public function showRegister(): void
    {
        $this->redirectIfSignedIn();
        $this->renderRegister();
    }

    public function register(): void
    {
        $this->redirectIfSignedIn();

        $result = AuthService::make()->register($_POST);
        if ($result['ok']) {
            Session::flash('success', 'Your account is ready.');
            redirect('/dashboard');
        }

        $this->renderRegister($result['errors'], $result['old']);
    }

    public function logout(): void
    {
        AuthService::logout();
        Session::flash('success', 'You signed out.');
        redirect('/');
    }

    private function redirectIfSignedIn(): void
    {
        if (AuthService::check()) {
            redirect('/dashboard');
        }
    }

    /** @param array<string, string> $errors */
    private function renderLogin(array $errors = [], array $old = []): void
    {
        View::render('auth/login.php', [
            'title' => 'Sign in',
            'currentNav' => 'login',
            'errors' => $errors,
            'old' => $old + ['email' => ''],
        ]);
    }

    /** @param array<string, string> $errors */
    private function renderRegister(array $errors = [], array $old = []): void
    {
        View::render('auth/register.php', [
            'title' => 'Create account',
            'currentNav' => 'register',
            'errors' => $errors,
            'old' => $old + ['full_name' => '', 'email' => ''],
        ]);
    }
}
