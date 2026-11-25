<?php

declare(strict_types=1);

$errors = $errors ?? [];
$old = $old ?? ['full_name' => '', 'email' => ''];
?>
<div class="auth-page">
    <header class="auth-page__intro">
        <p class="eyebrow">New on campus</p>
        <h1 class="page-title">Create account</h1>
        <p class="lead">Student accounts start here. Staff accounts are created by an admin.</p>
    </header>

    <section class="card auth-card">
        <form class="form form--auth" action="<?= e(url('/register')) ?>" method="post" novalidate>
            <?= csrf_field() ?>
            <div class="form__field">
                <label class="form__label" for="full_name">Full name</label>
                <input
                    class="form__input<?= isset($errors['full_name']) ? ' is-invalid' : '' ?>"
                    id="full_name"
                    name="full_name"
                    type="text"
                    autocomplete="name"
                    value="<?= e($old['full_name'] ?? '') ?>"
                    required
                >
                <?php if (isset($errors['full_name'])): ?>
                    <p class="form__error"><?= e($errors['full_name']) ?></p>
                <?php endif; ?>
            </div>

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

            <div class="form__row">
                <div class="form__field">
                    <label class="form__label" for="password">Password</label>
                    <input
                        class="form__input<?= isset($errors['password']) ? ' is-invalid' : '' ?>"
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                    <?php if (isset($errors['password'])): ?>
                        <p class="form__error"><?= e($errors['password']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="form__field">
                    <label class="form__label" for="password_confirm">Confirm password</label>
                    <input
                        class="form__input<?= isset($errors['password_confirm']) ? ' is-invalid' : '' ?>"
                        id="password_confirm"
                        name="password_confirm"
                        type="password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                    <?php if (isset($errors['password_confirm'])): ?>
                        <p class="form__error"><?= e($errors['password_confirm']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <p class="form__hint">Use at least 8 characters for the password.</p>

            <button class="btn btn--primary btn--block" type="submit">Create account</button>
        </form>
    </section>

    <p class="auth-page__switch">Already have an account? <a href="<?= e(url('/login')) ?>">Sign in</a></p>
</div>
