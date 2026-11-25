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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('/assets/css/main.css')) ?>">
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    <?php require __DIR__ . '/../partials/navbar.php'; ?>
    <main id="main" class="page">
        <div class="container">
            <?php require __DIR__ . '/../partials/flash.php'; ?>
            <?= $content ?>
        </div>
    </main>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
