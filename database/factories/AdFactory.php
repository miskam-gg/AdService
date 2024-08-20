<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'photos' => [$this->faker->imageUrl(), $this->faker->imageUrl()],
            'price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
