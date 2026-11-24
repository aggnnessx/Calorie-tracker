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
    'menu' => ['label' => 'Menu', 'href' => '/'],
    'diary' => ['label' => 'Diary', 'href' => '/diary'],
    'goals' => ['label' => 'Goals', 'href' => '/goals'],
    'weight' => ['label' => 'Weight', 'href' => '/weight'],
];
?>
<header class="navbar">
    <div class="container navbar__inner">
        <a class="navbar__brand" href="/"><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></a>
        <nav class="navbar__links" aria-label="Main">
            <?php foreach ($links as $key => $link): ?>
                <a
                    class="navbar__link<?= $currentNav === $key ? ' is-active' : '' ?>"
                    href="<?= htmlspecialchars($link['href'], ENT_QUOTES, 'UTF-8') ?>"
                    <?= $currentNav === $key ? 'aria-current="page"' : '' ?>
                ><?= htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8') ?></a>
            <?php endforeach; ?>
        </nav>
        <a class="btn btn--primary btn--small" href="/login">Sign in</a>
    </div>
</header>
