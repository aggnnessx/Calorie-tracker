<?php

declare(strict_types=1);

$appName = $appName ?? ($_ENV['APP_NAME'] ?? 'UCA Calorie Tracker');
$currentNav = $currentNav ?? '';

$links = [
    'menu' => ['label' => 'Menu', 'href' => url('/')],
    'diary' => ['label' => 'Diary', 'href' => url('/diary')],
    'goals' => ['label' => 'Goals', 'href' => url('/goals')],
    'weight' => ['label' => 'Weight', 'href' => url('/weight')],
];
?>
<header class="navbar">
    <div class="container navbar__inner">
        <a class="navbar__brand" href="<?= e(url('/')) ?>"><?= e($appName) ?></a>
        <nav class="navbar__links" aria-label="Main">
            <?php foreach ($links as $key => $link): ?>
                <a
                    class="navbar__link<?= $currentNav === $key ? ' is-active' : '' ?>"
                    href="<?= e($link['href']) ?>"
                    <?= $currentNav === $key ? 'aria-current="page"' : '' ?>
                ><?= e($link['label']) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="navbar__actions">
            <a class="btn btn--secondary btn--small" href="<?= e(url('/register')) ?>">Create account</a>
            <a class="btn btn--primary btn--small" href="<?= e(url('/login')) ?>">Sign in</a>
        </div>
    </div>
</header>
