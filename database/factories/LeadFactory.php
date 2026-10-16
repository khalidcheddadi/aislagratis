<?php

namespace Database\Factories;

use App\Enums\LeadStatus;
use App\Enums\PropertyType;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'postal_code' => fake()->postcode(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'province' => fake()->state(),
            'property_type' => fake()->randomElement(PropertyType::cases()),
            'area_m2' => fake()->numberBetween(60, 500),
            'year_built' => fake()->numberBetween(1950, 2020),
            'has_attic' => fake()->boolean(30),
            'has_basement' => fake()->boolean(40),
            'message' => fake()->paragraph(),
            'status' => LeadStatus::NEW,
            'source' => 'web',
            'is_covered' => true,
        ];
    }

    public function contacted(): static
    {
        return $this->state(fn () => [
            'status' => LeadStatus::CONTACTED,
            'contacted_at' => now(),
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(fn () => ['status' => LeadStatus::SCHEDULED]);
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => LeadStatus::COMPLETED,
            'converted_at' => now(),
        ]);
    }
}
