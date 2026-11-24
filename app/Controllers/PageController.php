<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;

final class PageController
{
    public function home(): void
    {
        View::render('home.php', [
            'title' => 'Home',
            'currentNav' => 'menu',
        ]);
    }

    public function diary(): void
    {
        View::render('placeholder.php', [
            'title' => 'Diary',
            'currentNav' => 'diary',
            'heading' => 'Food diary',
            'message' => 'Breakfast, lunch, dinner, and snacks for the selected day will be logged here.',
        ]);
    }

    public function goals(): void
    {
        View::render('placeholder.php', [
            'title' => 'Goals',
            'currentNav' => 'goals',
            'heading' => 'Nutrition goals',
            'message' => 'Calorie and macro targets calculated from the student profile will show here.',
        ]);
    }

    public function weight(): void
    {
        View::render('placeholder.php', [
            'title' => 'Weight',
            'currentNav' => 'weight',
            'heading' => 'Weight log',
            'message' => 'One weigh-in per day will be recorded here.',
        ]);
    }
}
