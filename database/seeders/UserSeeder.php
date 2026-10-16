<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing']) || ! config('aislaplus.seed_demo_users')) {
            return;
        }

        $accounts = [
            ['key' => 'admin', 'role' => UserRole::ADMIN],
            ['key' => 'sales', 'role' => UserRole::SALES],
            ['key' => 'technician', 'role' => UserRole::TECHNICIAN],
        ];

        foreach ($accounts as $account) {
            $attributes = config('aislaplus.seeded_users.'.$account['key']);

            if (blank($attributes['password'])) {
                throw new RuntimeException('Set a demo password for '.$account['key'].' before enabling demo user seeding.');
            }

            $user = User::firstOrCreate(
                ['email' => $attributes['email']],
                [
                    'first_name' => $attributes['first_name'],
                    'last_name' => $attributes['last_name'],
                    'password' => Hash::make($attributes['password']),
                    'role' => $account['role'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );

            $user->assignRole($account['role']->value);
        }

        User::factory(10)->create()->each(
            fn ($u) => $u->assignRole(UserRole::CUSTOMER->value)
        );
    }
}
