<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'description' => fake()->paragraph(),
            'icon_class' => 'fa-solid fa-tools',
            'base_price' => fake()->numberBetween(500, 5000),
            'estimated_hours' => fake()->numberBetween(8, 60),
            'sort_order' => fake()->numberBetween(0, 20),
            'is_active' => true,
        ];
    }
}
