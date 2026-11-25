<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

final class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public static function make(): self
    {
        try {
            $pdo = Database::get();
        } catch (\RuntimeException) {
            $config = require ROOT_PATH . '/config/database.php';
            $pdo = Database::connect($config);
        }

        return new self($pdo);
    }

    /** @return array<string, mixed>|null */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, email, password_hash, full_name, role, is_active, onboarding_done, created_at, last_login_at
             FROM users
             WHERE email = :email
             LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    /** @return array<string, mixed>|null */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, email, password_hash, full_name, role, is_active, onboarding_done, created_at, last_login_at
             FROM users
             WHERE id = :id
             LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function markLastLogin(int $id): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE users SET last_login_at = CURRENT_TIMESTAMP WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
    }

    public function create(string $email, string $passwordHash, string $fullName, string $role = 'student'): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (email, password_hash, full_name, role)
             VALUES (:email, :password_hash, :full_name, :role)'
        );
        $stmt->execute([
            'email' => $email,
            'password_hash' => $passwordHash,
            'full_name' => $fullName,
            'role' => $role,
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}
