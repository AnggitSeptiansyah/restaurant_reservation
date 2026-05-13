<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(10000, 500000),
            'description' => $this->faker->sentence,
            'image' => 'public/menus/dummy.jpeg', // dummy, akan diganti saat test
        ];
    }
}