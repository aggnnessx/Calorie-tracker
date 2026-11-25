<?php

declare(strict_types=1);

$heading = $heading ?? 'Coming next';
$message = $message ?? 'This screen will be filled in on a later step.';
?>
<section class="hero">
    <div class="hero__copy">
        <p class="eyebrow">UCA Nutrition</p>
        <h1 class="page-title"><?= e($heading) ?></h1>
        <p class="lead"><?= e($message) ?></p>
        <div class="hero__actions">
            <a class="btn btn--primary" href="<?= e(url('/')) ?>">Back to the menu</a>
        </div>
    </div>
    <aside class="card">
        <h2 class="card__title">Nothing saved for this screen yet</h2>
        <p class="card__text">The layout is ready. Data for this page will connect in a later step.</p>
    </aside>
</section>
