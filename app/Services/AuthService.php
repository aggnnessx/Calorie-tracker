<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Session;
use App\Core\Validator;
use App\Repositories\UserRepository;

final class AuthService
{
    public function __construct(private UserRepository $users)
    {
    }

    public static function make(): self
    {
        return new self(UserRepository::make());
    }

    public static function check(): bool
    {
        Session::start();
        return isset($_SESSION['user']['id']);
    }

    /** @return array{id: int, email: string, full_name: string, role: string}|null */
    public static function user(): ?array
    {
        Session::start();
        $user = $_SESSION['user'] ?? null;
        return is_array($user) ? $user : null;
    }

    public static function isAdmin(): bool
    {
        return (self::user()['role'] ?? '') === 'admin';
    }

    /**
     * @param array<string, mixed> $input
     * @return array{ok: bool, errors: array<string, string>, old: array<string, string>}
     */
    public function register(array $input): array
    {
        $validator = new Validator($input);
        $validator
            ->required('full_name', 'Full name')
            ->required('email')
            ->email('email')
            ->required('password', 'Password')
            ->minLength('password', 8)
            ->required('password_confirm', 'Confirm password');

        $password = $validator->value('password');
        $confirm = $validator->value('password_confirm');
        if ($password !== '' && $confirm !== '' && $password !== $confirm) {
            $validator->addError('password_confirm', 'Passwords do not match.');
        }

        $email = $validator->value('email');
        if ($email !== '' && $this->users->findByEmail($email) !== null) {
            $validator->addError('email', 'That email is already registered.');
        }

        $old = [
            'full_name' => $validator->value('full_name'),
            'email' => $email,
        ];

        if ($validator->fails()) {
            return ['ok' => false, 'errors' => $validator->errors(), 'old' => $old];
        }

        $id = $this->users->create(
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $validator->value('full_name'),
            'student'
        );

        $created = $this->users->findById($id);
        if ($created !== null) {
            $this->establish($created);
        }

        return ['ok' => true, 'errors' => [], 'old' => $old];
    }

    /**
     * @param array<string, mixed> $input
     * @return array{ok: bool, errors: array<string, string>, old: array<string, string>}
     */
    public function login(array $input): array
    {
        $validator = new Validator($input);
        $validator->required('email')->email('email')->required('password', 'Password');

        $old = ['email' => $validator->value('email')];

        if ($validator->fails()) {
            return ['ok' => false, 'errors' => $validator->errors(), 'old' => $old];
        }

        $user = $this->users->findByEmail($validator->value('email'));
        $hash = is_array($user) ? (string) ($user['password_hash'] ?? '') : '';
        $password = $validator->value('password');
        $active = is_array($user) && (int) ($user['is_active'] ?? 0) === 1;

        if ($user === null || !$active || $hash === '' || !password_verify($password, $hash)) {
            return [
                'ok' => false,
                'errors' => ['email' => 'Those details do not match our records.'],
                'old' => $old,
            ];
        }

        $this->establish($user);
        $this->users->markLastLogin((int) $user['id']);

        return ['ok' => true, 'errors' => [], 'old' => $old];
    }

    public static function logout(): void
    {
        Session::forget();
        Session::start();
        Session::regenerate();
    }

    /** @param array<string, mixed> $user */
    private function establish(array $user): void
    {
        Session::start();
        Session::regenerate();
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'email' => (string) $user['email'],
            'full_name' => (string) $user['full_name'],
            'role' => (string) $user['role'],
        ];
    }
}
