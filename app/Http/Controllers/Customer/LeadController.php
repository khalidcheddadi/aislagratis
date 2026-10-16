<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $leads = $request->user()->leads()->latest()->paginate(10);

        return view('customer.leads.index', compact('leads'));
    }

    public function show(Request $request, Lead $lead): View
    {
        abort_unless($lead->user_id === $request->user()->id, 403);
        $lead->load(['service', 'appointments.technician']);

        return view('customer.leads.show', compact('lead'));
    }
}
