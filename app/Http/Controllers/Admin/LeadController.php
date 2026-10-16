<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLeadStatusRequest;
use App\Models\Lead;
use App\Services\LeadService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    public function __construct(protected LeadService $service)
    {
        $this->authorizeResource(Lead::class, 'lead');
    }

    public function index(Request $request): View
    {
        $leads = $this->service->paginate($request->only([
            'status', 'search', 'service_id', 'date_from', 'date_to',
        ]));

        return view('admin.leads.index', [
            'leads' => $leads,
            'statuses' => LeadStatus::cases(),
            'filters' => $request->only(['status', 'search', 'service_id']),
        ]);
    }

    public function show(Lead $lead): View
    {
        $lead->load([
            'user',
            'service',
            'appointments.technician',
            'appointments.installation',
        ]);

        return view('admin.leads.show', compact('lead'));
    }

    public function updateStatus(UpdateLeadStatusRequest $request, Lead $lead)
    {
        $this->service->updateStatus(
            $lead,
            LeadStatus::from($request->validated('status')),
            $request->user()
        );

        return back()->with('success', 'Estado actualizado correctamente.');
    }

    public function export(Lead $lead): StreamedResponse
    {
        $data = $this->service->exportToArray($lead);

        return response()->streamDownload(function () use ($data) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, array_keys($data));
            fputcsv($out, array_values($data));
            fclose($out);
        }, "lead-{$lead->id}.csv", ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
