<?php

namespace App\Http\Controllers\Customer;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $dashboard): View
    {
        $customer = auth()->user();
        $stats = $dashboard->getCustomerStats($customer);
        $upcomingAppointments = $customer->appointments()
            ->with('lead:id,first_name,last_name,city,address')
            ->where('appointment_date', '>=', now())
            ->whereIn('status', [AppointmentStatus::PENDING, AppointmentStatus::CONFIRMED])
            ->orderBy('appointment_date')
            ->limit(5)
            ->get();
        $recentInstallations = $customer->installations()
            ->with('service:id,name')
            ->latest('installation_date')
            ->limit(5)
            ->get();
        $monthlyLeadCounts = $customer->leads()
            ->where('created_at', '>=', now()->startOfMonth()->subMonths(5))
            ->get(['created_at'])
            ->groupBy(fn ($lead) => $lead->created_at->format('Y-m'));
        $monthlyLeads = collect(range(5, 0))->map(function ($monthsAgo) use ($monthlyLeadCounts) {
            $month = now()->startOfMonth()->subMonths($monthsAgo);

            return [
                'label' => $month->translatedFormat('M'),
                'count' => $monthlyLeadCounts->get($month->format('Y-m'), collect())->count(),
            ];
        });
        $leadStatuses = $customer->leads()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();
        $unreadNotifications = $customer->unreadNotifications()->latest()->limit(4)->get();

        return view('customer.dashboard', compact(
            'stats', 'upcomingAppointments', 'recentInstallations', 'monthlyLeads',
            'leadStatuses', 'unreadNotifications'
        ));
    }
}
