<?php

declare(strict_types=1);

$user = $user ?? null;
$name = is_array($user) ? (string) ($user['full_name'] ?? 'there') : 'there';
?>
<section class="hero">
    <div class="hero__copy">
        <p class="eyebrow">Your day</p>
        <h1 class="page-title">Hello, <?= e($name) ?></h1>
        <p class="lead">Signed in. Use today’s cafeteria line to fill the remaining calories and protein — the kitchen does not charge students.</p>
        <div class="hero__actions">
            <a class="btn btn--primary" href="<?= e(url('/')) ?>">Open today’s menu</a>
            <a class="btn btn--ghost" href="<?= e(url('/goals')) ?>">Review goals</a>
        </div>
    </div>
    <aside class="macro macro--feature">
        <span class="macro__label">Today’s target</span>
        <span class="macro__value">2,100 kcal</span>
        <p class="macro__meta">Protein 130 g · Carbs 230 g · Fat 70 g</p>
    </aside>
</section>

<section class="card">
    <h2 class="card__title">Nothing saved for this screen yet</h2>
    <p class="card__text">When meals are logged, this dashboard will show eaten / goal / remaining for the day.</p>
</section>
