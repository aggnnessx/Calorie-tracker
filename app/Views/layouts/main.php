<?php

declare(strict_types=1);

/**
 * Shared page layout.
 *
 * Variables:
 * - string $title      Browser title (page name only)
 * - string $content    Rendered HTML for the page body
 * - string $currentNav Active navbar key: menu, diary, goals, weight
 */

$title = $title ?? 'Home';
$content = $content ?? '';
$appName = $_ENV['APP_NAME'] ?? 'UCA Calorie Tracker';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?>
    <main class="page">
        <div class="container">
            <?= $content ?>
        </div>
    </main>
</body>
</html>
