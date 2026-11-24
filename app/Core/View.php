<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    /** @param array<string, mixed> $data */
    public static function render(string $template, array $data = [], string $layout = 'layouts/main.php'): void
    {
        echo self::make($template, $data, $layout);
    }

    /** @param array<string, mixed> $data */
    public static function make(string $template, array $data = [], ?string $layout = 'layouts/main.php'): string
    {
        $viewFile = ROOT_PATH . '/app/Views/' . $template;
        if (!is_file($viewFile)) {
            throw new \RuntimeException('View not found: ' . $template);
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = (string) ob_get_clean();

        if ($layout === null) {
            return $content;
        }

        $layoutFile = ROOT_PATH . '/app/Views/' . $layout;
        if (!is_file($layoutFile)) {
            throw new \RuntimeException('Layout not found: ' . $layout);
        }

        ob_start();
        require $layoutFile;
        return (string) ob_get_clean();
    }
}
