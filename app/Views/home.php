<?php

declare(strict_types=1);
?>
<div class="stack">
    <header>
        <span class="badge">Campus cafeteria</span>
        <h1 class="page-title">Plan today’s meals</h1>
        <p class="lead">See the published menu, log what you eat, and stay inside the calorie and macro targets from your profile.</p>
    </header>

    <div class="grid-2">
        <section class="card">
            <h2 class="card__title">Log a meal</h2>
            <p class="card__text">Pick a meal and how many portions you ate.</p>
            <form class="form" action="/" method="get">
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
                    <a class="btn btn--secondary" href="/">Cancel</a>
                </div>
            </form>
        </section>

        <aside class="stack">
            <section class="card stat">
                <span class="stat__label">Today’s target</span>
                <span class="stat__value">2,100 kcal</span>
                <p class="card__text">Protein 130 g · Carbs 230 g · Fat 70 g</p>
            </section>
            <section class="card">
                <h2 class="card__title">On the menu</h2>
                <p class="card__text">Published dishes for today will list here once the daily menu is filled in.</p>
            </section>
        </aside>
    </div>
</div>
