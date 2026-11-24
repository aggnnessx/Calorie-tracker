<?php

declare(strict_types=1);

$title = $title ?? 'Home';
$content = $content ?? '';
$appName = $_ENV['APP_NAME'] ?? 'UCA Calorie Tracker';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> · <?= e($appName) ?></title>
    <link rel="stylesheet" href="<?= e(url('/assets/css/main.css')) ?>">
</head>
<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?>
    <main class="page">
        <div class="container">
            <?php require __DIR__ . '/../partials/flash.php'; ?>
            <?= $content ?>
        </div>
    </main>
</body>
</html>
