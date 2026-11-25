<?php

declare(strict_types=1);

$user = $user ?? null;
$name = is_array($user) ? (string) ($user['full_name'] ?? 'there') : 'there';
?>
<div class="stack">
    <header>
        <h1 class="page-title">Dashboard</h1>
        <p class="lead">Signed in as <?= e($name) ?>. Meal logging and goals will land here next.</p>
    </header>
    <section class="card">
        <p class="card__text">Nothing saved for this screen yet.</p>
    </section>
</div>
