<?php

namespace Database\Factories;

/* заголовки файла */

use App\Components\Translit;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogArticleFactory extends Factory
{
    /* остальная часть класса */

    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->name,
            'title_ua' => Translit::process($title, 'ua'),
            'title_en' => Translit::process($title, 'en'),
            'text' => $text = $this->faker->sentence,
            'text_ua' => Translit::process($text, 'ua'),
            'text_en' => Translit::process($text, 'en'),
        ];
    }
}
