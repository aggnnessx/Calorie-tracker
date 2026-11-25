<?php

declare(strict_types=1);

$errors = $errors ?? [];
$old = $old ?? ['email' => ''];
?>
<div class="auth-page">
    <header class="auth-page__intro">
        <h1 class="page-title">Sign in</h1>
        <p class="lead">Use your campus email and password.</p>
    </header>

    <section class="card auth-card">
        <form class="form form--auth" action="<?= e(url('/login')) ?>" method="post" novalidate>
            <?= csrf_field() ?>
            <div class="form__field">
                <label class="form__label" for="email">Email</label>
                <input
                    class="form__input<?= isset($errors['email']) ? ' is-invalid' : '' ?>"
                    id="email"
                    name="email"
                    type="email"
                    inputmode="email"
                    autocomplete="email"
                    value="<?= e($old['email'] ?? '') ?>"
                    required
                >
                <?php if (isset($errors['email'])): ?>
                    <p class="form__error"><?= e($errors['email']) ?></p>
                <?php endif; ?>
            </div>

            <div class="form__field">
                <label class="form__label" for="password">Password</label>
                <input
                    class="form__input<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                >
                <?php if (isset($errors['password'])): ?>
                    <p class="form__error"><?= e($errors['password']) ?></p>
                <?php endif; ?>
            </div>

            <button class="btn btn--primary btn--block" type="submit">Sign in</button>
        </form>
    </section>

    <p class="auth-page__switch">New here? <a href="<?= e(url('/register')) ?>">Create an account</a></p>
</div>
