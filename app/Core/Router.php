<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    /** @var array<string, array<string, callable>> */
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    public function dispatch(?string $method = null, ?string $path = null): void
    {
        $method = strtoupper($method ?? ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
        if ($method === 'HEAD') {
            $method = 'GET';
        }

        $path = self::normalize($path ?? app_request_path());
        $handler = $this->routes[$method][$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            View::render('placeholder.php', [
                'title' => 'Not found',
                'currentNav' => '',
                'heading' => 'Page not found',
                'message' => 'That address is not part of the app yet.',
            ]);
            return;
        }

        $handler();
    }

    private function add(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][self::normalize($path)] = $handler;
    }

    public static function normalize(string $path): string
    {
        $path = '/' . ltrim($path, '/');
        return rtrim($path, '/') ?: '/';
    }
}
