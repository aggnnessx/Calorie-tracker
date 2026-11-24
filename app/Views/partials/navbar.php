<?php

declare(strict_types=1);

/**
 * Main navigation.
 *
 * Expects optional $appName and $currentNav from the layout.
 */

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
        <a class="navbar__brand" href="<?= htmlspecialchars(url('/'), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></a>
        <nav class="navbar__links" aria-label="Main">
            <?php foreach ($links as $key => $link): ?>
                <a
                    class="navbar__link<?= $currentNav === $key ? ' is-active' : '' ?>"
                    href="<?= htmlspecialchars($link['href'], ENT_QUOTES, 'UTF-8') ?>"
                    <?= $currentNav === $key ? 'aria-current="page"' : '' ?>
                ><?= htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8') ?></a>
            <?php endforeach; ?>
        </nav>
        <a class="btn btn--primary btn--small" href="<?= htmlspecialchars(url('/login'), ENT_QUOTES, 'UTF-8') ?>">Sign in</a>
    </div>
</header>
