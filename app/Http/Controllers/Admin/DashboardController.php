<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\DashboardService;
use App\Services\NotificationService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(
        DashboardService $dashboard,
        NotificationService $notificationService,
    ): View {
        $stats = $dashboard->getAdminStats();
        $recentLeads = Lead::with(['service:id,name'])
            ->latest()
            ->limit(8)
            ->get();
        $unreadNotifications = $notificationService->forUser(auth()->user(), 5);

        return view('admin.home', compact('stats', 'recentLeads', 'unreadNotifications'));
    }
}
