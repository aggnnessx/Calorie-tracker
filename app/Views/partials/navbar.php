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
            <?php if ($signedIn): ?>
                <span class="navbar__user"><?= e($user['full_name'] ?? '') ?></span>
                <form class="navbar__logout" action="<?= e(url('/logout')) ?>" method="post">
                    <?= csrf_field() ?>
                    <button class="btn btn--secondary btn--small" type="submit">Log out</button>
                </form>
            <?php else: ?>
                <a class="btn btn--secondary btn--small" href="<?= e(url('/register')) ?>">Create account</a>
                <a class="btn btn--primary btn--small" href="<?= e(url('/login')) ?>">Sign in</a>
            <?php endif; ?>
        </div>
    </div>
</header>
