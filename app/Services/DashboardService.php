<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Installation;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function getAdminStats(): array
    {
        return Cache::remember('dashboard.admin.stats', now()->addMinutes(5), function () {
            return [
                'total_users' => User::count(),
                'total_customers' => User::customers()->count(),
                'total_leads' => Lead::count(),
                'new_leads' => Lead::where('status', 'nuevo')->count(),
                'pending_appointments' => Appointment::pending()->count(),
                'completed_installations' => Installation::completed()->count(),
                'revenue' => Installation::completed()
                    ->selectRaw('SUM(total_cost - subsidy_amount) as total')
                    ->value('total') ?? 0,
            ];
        });
    }

    public function getCustomerStats(User $user): array
    {
        return Cache::remember(
            "dashboard.customer.{$user->id}",
            now()->addMinutes(5),
            fn () => [
                'total_leads' => $user->leads()->count(),
                'pending_leads' => $user->leads()->pending()->count(),
                'total_installations' => $user->installations()->count(),
                'total_savings' => $user->installations()
                    ->where('status', 'completada')
                    ->selectRaw('SUM(total_cost - subsidy_amount) as total')
                    ->value('total') ?? 0,
            ]
        );
    }
}
