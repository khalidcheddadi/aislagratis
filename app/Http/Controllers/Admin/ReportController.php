<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Installation;
use App\Models\Lead;
use App\Models\User;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        $leadStats = Lead::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $instStats = Installation::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $totalRevenue = Installation::completed()
            ->selectRaw('SUM(total_cost - subsidy_amount) as total')
            ->value('total') ?? 0;

        $totalCustomers = User::customers()->count();

        return view('admin.reports.index', compact(
            'leadStats', 'instStats', 'totalRevenue', 'totalCustomers'
        ));
    }
}
