<?php

declare(strict_types=1);

$heading = $heading ?? 'Coming next';
$message = $message ?? 'This screen will be filled in on a later step.';
?>
<div class="stack">
    <header>
        <h1 class="page-title"><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="lead"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    </header>
    <section class="card">
        <p class="card__text">Nothing saved for this screen yet.</p>
    </section>
</div>
