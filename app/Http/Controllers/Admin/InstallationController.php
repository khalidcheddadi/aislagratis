<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InstallationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInstallationRequest;
use App\Models\Appointment;
use App\Models\Installation;
use App\Models\Service;
use App\Models\User;
use App\Services\InstallationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InstallationController extends Controller
{
    public function __construct(protected InstallationService $service)
    {
        $this->authorizeResource(Installation::class, 'installation');
    }

    public function index(Request $request): View
    {
        $installations = $this->service->paginate($request->only([
            'status', 'service_id',
        ]));

        return view('admin.installations.index', [
            'installations' => $installations,
            'services' => Service::active()->get(['id', 'name']),
        ]);
    }

    public function updateStatus(Request $request, Installation $installation)
    {
        $this->authorize('update', $installation);
        $request->validate([
            'status' => ['required', Rule::enum(InstallationStatus::class)],
        ]);

        $this->service->updateStatus(
            $installation,
            InstallationStatus::from($request->status),
            $request->user()
        );

        return back()->with('success', 'Estado de instalación actualizado.');
    }

    public function create(Request $request): View
    {
        return view('admin.installations.create', [
            'customers' => User::customers()->get(['id', 'first_name', 'last_name', 'email']),
            'services' => Service::active()->get(['id', 'name']),
            'appointments' => Appointment::with('lead:id,first_name,last_name')
                ->whereDoesntHave('installation')
                ->latest('appointment_date')
                ->get(['id', 'lead_id', 'appointment_date']),
            'preselectedAppointmentId' => $request->integer('appointment_id'),
        ]);
    }

    public function store(StoreInstallationRequest $request)
    {
        $this->service->create($request->validated(), $request->user());

        return redirect()
            ->route('admin.installations.index')
            ->with('success', 'Instalación registrada.');
    }
}
