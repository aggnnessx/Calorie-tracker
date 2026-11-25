<?php

declare(strict_types=1);
?>
<section class="hero">
    <div class="hero__copy">
        <p class="eyebrow">Campus cafeteria</p>
        <h1 class="page-title">Plan today’s meals</h1>
        <p class="lead">Pick dishes from the free UCA menu and stay inside your calorie and protein target. No prices — just what is on the line today.</p>
        <div class="hero__actions">
            <a class="btn btn--primary" href="#today-menu">See today’s menu</a>
            <a class="btn btn--ghost" href="#log-meal">Log what you ate</a>
        </div>
    </div>
    <aside class="macro macro--feature">
        <span class="macro__label">Still to eat today</span>
        <span class="macro__value">700 kcal</span>
        <p class="macro__meta">50 g protein left · maintenance day</p>
    </aside>
</section>

<section class="stack" aria-labelledby="summary-heading">
    <h2 id="summary-heading" class="card__title">Eaten / goal / remaining</h2>
    <div class="macros">
        <article class="macro">
            <span class="macro__label">Energy</span>
            <span class="macro__value">1,400</span>
            <div class="macro__bar" role="progressbar" aria-valuemin="0" aria-valuemax="2100" aria-valuenow="1400" aria-label="Calories eaten">
                <span class="macro__fill macro__fill--kcal"></span>
            </div>
            <p class="macro__meta">1,400 / 2,100 kcal · 700 left</p>
        </article>
        <article class="macro">
            <span class="macro__label">Protein</span>
            <span class="macro__value">80 g</span>
            <div class="macro__bar" role="progressbar" aria-valuemin="0" aria-valuemax="130" aria-valuenow="80" aria-label="Protein eaten">
                <span class="macro__fill macro__fill--protein"></span>
            </div>
            <p class="macro__meta">80 / 130 g · 50 left</p>
        </article>
        <article class="macro">
            <span class="macro__label">Carbs</span>
            <span class="macro__value">180 g</span>
            <div class="macro__bar" role="progressbar" aria-valuemin="0" aria-valuemax="230" aria-valuenow="180" aria-label="Carbs eaten">
                <span class="macro__fill macro__fill--carbs"></span>
            </div>
            <p class="macro__meta">180 / 230 g · 50 left</p>
        </article>
        <article class="macro">
            <span class="macro__label">Fat</span>
            <span class="macro__value">50 g</span>
            <div class="macro__bar" role="progressbar" aria-valuemin="0" aria-valuemax="70" aria-valuenow="50" aria-label="Fat eaten">
                <span class="macro__fill macro__fill--fat"></span>
            </div>
            <p class="macro__meta">50 / 70 g · 20 left</p>
        </article>
    </div>
</section>

<div class="grid-2">
    <section class="card card--feature" id="log-meal">
        <h2 class="card__title">Log a meal</h2>
        <p class="card__text">Pick a meal and how many portions you ate.</p>
        <form class="form" action="<?= e(url('/')) ?>" method="get">
            <div class="form__row">
                <div class="form__field">
                    <label class="form__label" for="meal">Meal</label>
                    <select class="form__select" id="meal" name="meal">
                        <option>Breakfast</option>
                        <option>Lunch</option>
                        <option selected>Dinner</option>
                        <option>Snack</option>
                    </select>
                </div>
                <div class="form__field">
                    <label class="form__label" for="servings">Servings</label>
                    <input class="form__input" id="servings" name="servings" type="number" min="0.25" step="0.25" value="1">
                    <p class="form__hint">One serving matches the portion on the menu card.</p>
                </div>
            </div>
            <div class="form__field">
                <label class="form__label" for="note">Note</label>
                <textarea class="form__textarea" id="note" name="note" placeholder="Optional, for example “half portion”"></textarea>
            </div>
            <div class="btn-row">
                <button class="btn btn--primary" type="submit">Save meal</button>
                <a class="btn btn--ghost" href="<?= e(url('/')) ?>">Cancel</a>
            </div>
        </form>
    </section>

    <section class="combo combo--fit" aria-labelledby="combo-heading">
        <p class="eyebrow">Fits what is left</p>
        <h2 class="card__title" id="combo-heading">Lagman and cabbage salad</h2>
        <p class="card__text">One bowl of lagman plus a side salad uses most of the remaining energy without going over protein.</p>
        <div class="combo__totals">
            <div>
                <span class="macro__label">Combo energy</span>
                <p class="combo__number">680 kcal</p>
            </div>
            <div>
                <span class="macro__label">Combo protein</span>
                <p class="combo__number">48 g</p>
            </div>
        </div>
        <p class="combo__fit">Leaves 20 kcal and 2 g protein.</p>
    </section>
</div>

<section class="stack" id="today-menu" aria-labelledby="menu-heading">
    <div>
        <p class="eyebrow">On the line</p>
        <h2 id="menu-heading">Today’s menu</h2>
        <p class="lead">Published dishes for today. Portions match the cafeteria serving.</p>
    </div>
    <div class="food-grid">
        <article class="food-card food-card--wide">
            <div>
                <h3 class="food-card__name">Lagman</h3>
                <p class="food-card__portion">1 bowl · 350 g</p>
            </div>
            <div class="food-card__pills">
                <span class="pill">520 kcal</span>
                <span class="pill pill--green">32 g protein</span>
                <span class="pill pill--muted">58 g carbs</span>
                <span class="pill pill--muted">18 g fat</span>
            </div>
            <div class="food-card__actions">
                <span class="card__text">Main</span>
                <button class="btn btn--primary btn--small" type="button">Add</button>
            </div>
        </article>
        <article class="food-card">
            <div>
                <h3 class="food-card__name">Plov</h3>
                <p class="food-card__portion">1 plate · 300 g</p>
            </div>
            <div class="food-card__pills">
                <span class="pill">560 kcal</span>
                <span class="pill pill--green">22 g protein</span>
            </div>
            <div class="food-card__actions">
                <span class="card__text">Main</span>
                <button class="btn btn--primary btn--small" type="button">Add</button>
            </div>
        </article>
        <article class="food-card">
            <div>
                <h3 class="food-card__name">Cabbage salad</h3>
                <p class="food-card__portion">1 bowl · 120 g</p>
            </div>
            <div class="food-card__pills">
                <span class="pill">80 kcal</span>
                <span class="pill pill--green">2 g protein</span>
            </div>
            <div class="food-card__actions">
                <span class="card__text">Side</span>
                <button class="btn btn--primary btn--small" type="button">Add</button>
            </div>
        </article>
        <article class="food-card">
            <div>
                <h3 class="food-card__name">Apple</h3>
                <p class="food-card__portion">1 piece · 150 g</p>
            </div>
            <div class="food-card__pills">
                <span class="pill">70 kcal</span>
                <span class="pill pill--muted">16 g carbs</span>
            </div>
            <div class="food-card__actions">
                <span class="card__text">Fruit</span>
                <button class="btn btn--primary btn--small" type="button">Add</button>
            </div>
        </article>
    </div>
</section>
