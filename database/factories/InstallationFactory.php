<?php

namespace Database\Factories;

use App\Enums\InstallationStatus;
use App\Models\Installation;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstallationFactory extends Factory
{
    protected $model = Installation::class;

    public function definition(): array
    {
        $total = fake()->numberBetween(1000, 8000);
        $subsidy = (int) ($total * 0.7);

        return [
            'user_id' => User::factory()->state(['role' => 'customer']),
            'service_id' => Service::factory(),
            'installation_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'total_cost' => $total,
            'subsidy_amount' => $subsidy,
            'status' => InstallationStatus::COMPLETED,
        ];
    }
}
