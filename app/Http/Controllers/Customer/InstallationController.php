<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Installation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstallationController extends Controller
{
    public function index(Request $request): View
    {
        $installations = $request->user()
            ->installations()
            ->with('service:id,name,description')
            ->latest('installation_date')
            ->paginate(10);

        return view('customer.installations.index', compact('installations'));
    }

    public function show(Request $request, Installation $installation): View
    {
        abort_unless($installation->user_id === $request->user()->id, 403);

        $installation->load(['service', 'appointment.technician', 'reviews']);

        return view('customer.installations.show', compact('installation'));
    }
}
