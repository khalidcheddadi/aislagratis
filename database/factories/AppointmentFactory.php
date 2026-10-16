<?php

namespace Database\Factories;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'lead_id' => Lead::factory(),
            'appointment_date' => fake()->dateTimeBetween('now', '+2 months'),
            'duration_minutes' => 60,
            'status' => AppointmentStatus::PENDING,
            'notes' => fake()->sentence(),
        ];
    }
}
