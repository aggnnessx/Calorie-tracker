<?php

declare(strict_types=1);

$appName = $appName ?? ($_ENV['APP_NAME'] ?? 'UCA Calorie Tracker');
?>
<footer class="footer">
    <div class="container footer__grid">
        <div>
            <p class="footer__brand"><?= e($appName) ?></p>
            <p class="footer__note">Campus meals are free. This tracker only counts energy and macros from today’s cafeteria menu.</p>
        </div>
        <ul class="footer__links">
            <li><a href="<?= e(url('/')) ?>">Menu</a></li>
            <li><a href="<?= e(url('/diary')) ?>">Diary</a></li>
            <li><a href="<?= e(url('/goals')) ?>">Goals</a></li>
            <li><a href="<?= e(url('/weight')) ?>">Weight</a></li>
            <li><a href="<?= e(url('/login')) ?>">Sign in</a></li>
        </ul>
    </div>
</footer>
