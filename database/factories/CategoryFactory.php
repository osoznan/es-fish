<?php

namespace Database\Factories;

/* заголовки файла */

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /* остальная часть класса */

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'main_page_present' => intval($this->faker->boolean),
        ];
    }
}
