<?php

declare(strict_types=1);

$appName = $appName ?? ($_ENV['APP_NAME'] ?? 'UCA Calorie Tracker');
$currentNav = $currentNav ?? '';
$signedIn = \App\Services\AuthService::check();
$user = \App\Services\AuthService::user();

$links = [
    'menu' => ['label' => 'Menu', 'href' => url('/')],
    'diary' => ['label' => 'Diary', 'href' => url('/diary')],
    'goals' => ['label' => 'Goals', 'href' => url('/goals')],
    'weight' => ['label' => 'Weight', 'href' => url('/weight')],
];

if ($signedIn) {
    $links = ['dashboard' => ['label' => 'Dashboard', 'href' => url('/dashboard')]] + $links;
}
?>
<header class="navbar">
    <div class="container navbar__inner">
        <a class="navbar__brand" href="<?= e(url('/')) ?>">
            <svg class="navbar__mark" viewBox="0 0 32 32" fill="none" aria-hidden="true">
                <rect width="32" height="32" rx="8" fill="url(#mark-ember)"/>
                <path d="M16 7.5c.2 2.4-.8 3.6.2 5.4 1 1.8.4 4.2-2.6 4.6-2.2.3-3.4-1.5-2.6-3.2.3 1.2 0 2-1 2.8C8.8 15.4 10.2 10.6 16 7.5Z" fill="#fff"/>
                <defs>
                    <radialGradient id="mark-ember" cx="0.3" cy="0.3" r="0.85">
                        <stop offset="0" stop-color="#ff6b35"/>
                        <stop offset="0.45" stop-color="#d62828"/>
                        <stop offset="1" stop-color="#6a0f0f"/>
                    </radialGradient>
                </defs>
            </svg>
            <?= e($appName) ?>
        </a>
        <input class="navbar__toggle" id="nav-toggle" type="checkbox">
        <label class="navbar__burger" for="nav-toggle" aria-label="Open menu">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </label>
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
            <?php if ($signedIn): ?>
                <span class="navbar__user"><?= e($user['full_name'] ?? '') ?></span>
                <form class="navbar__logout" action="<?= e(url('/logout')) ?>" method="post">
                    <?= csrf_field() ?>
                    <button class="btn btn--ghost btn--small" type="submit">Log out</button>
                </form>
            <?php else: ?>
                <a class="btn btn--ghost btn--small" href="<?= e(url('/register')) ?>">Create account</a>
                <a class="btn btn--primary btn--small" href="<?= e(url('/login')) ?>">Sign in</a>
            <?php endif; ?>
        </div>
    </div>
</header>
