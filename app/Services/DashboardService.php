<?php

namespace App\Services;

use App\Enums\LeadStatus;
use App\Models\Appointment;
use App\Models\Installation;
use App\Models\Lead;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getAdminDashboardInsights(): array
    {
        $start = CarbonImmutable::now()->startOfMonth()->subMonths(6);
        $driver = DB::connection()->getDriverName();
        $monthExpression = match ($driver) {
            'mysql', 'mariadb' => "DATE_FORMAT(created_at, '%Y-%m')",
            'sqlite' => "strftime('%Y-%m', created_at)",
            'pgsql' => "TO_CHAR(created_at, 'YYYY-MM')",
            default => throw new \RuntimeException("Unsupported database driver for dashboard trends: {$driver}"),
        };

        $monthlyCounts = Lead::query()
            ->where('created_at', '>=', $start)
            ->selectRaw("{$monthExpression} as month, COUNT(*) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyLeads = collect(range(0, 6))
            ->map(function (int $offset) use ($start, $monthlyCounts) {
                $month = $start->addMonths($offset);
                $key = $month->format('Y-m');

                return [
                    'key' => $key,
                    'label' => $month->translatedFormat('M'),
                    'total' => (int) ($monthlyCounts[$key] ?? 0),
                ];
            });

        $leadStatuses = collect(LeadStatus::cases())
            ->map(fn (LeadStatus $status) => [
                'label' => $status->label(),
                'value' => $status->value,
                'total' => Lead::query()->where('status', $status->value)->count(),
            ]);

        $topLocations = Lead::query()
            ->whereNotNull('province')
            ->where('province', '<>', '')
            ->selectRaw('province as location_name, COUNT(*) as total')
            ->groupBy('province')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn ($location) => [
                'name' => $location->location_name,
                'total' => (int) $location->total,
            ]);

        return [
            'monthly_leads' => $monthlyLeads,
            'lead_statuses' => $leadStatuses,
            'top_locations' => $topLocations,
        ];
    }

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
