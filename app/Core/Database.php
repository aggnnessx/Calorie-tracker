<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

// Simple PDO connection helper.
final class Database
{
    private static ?PDO $pdo = null;

    public static function connect(array $config): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['dbname'],
            $config['charset'] ?? 'utf8mb4'
        );

        try {
            self::$pdo = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options'] ?? []
            );
        } catch (PDOException $e) {
            throw new PDOException(
                'Database connection failed: ' . $e->getMessage(),
                (int) $e->getCode(),
                $e
            );
        }

        return self::$pdo;
    }

    public static function get(): PDO
    {
        if (!self::$pdo instanceof PDO) {
            throw new \RuntimeException('Database not connected. Call Database::connect() first.');
        }
        return self::$pdo;
    }

    // Useful for tests / fresh install checks.
    public static function reset(): void
    {
        self::$pdo = null;
    }
}