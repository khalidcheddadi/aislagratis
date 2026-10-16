<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Lead;
use App\Models\User;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function __construct(protected AppointmentService $service)
    {
        $this->authorizeResource(Appointment::class, 'appointment');
    }

    public function index(Request $request): View
    {
        $filters = $request->only([
            'status', 'technician_id', 'date',
        ]);
        $upcomingCount = null;
        if ($request->user()->isTechnician()) {
            $filters['technician_id'] = $request->user()->id;
            $upcomingCount = Appointment::where('technician_id', $request->user()->id)
                ->where('appointment_date', '>=', now())
                ->whereIn('status', [AppointmentStatus::PENDING, AppointmentStatus::CONFIRMED])
                ->count();
        }
        $appointments = $this->service->paginate($filters);

        return view('admin.appointments.index', [
            'appointments' => $appointments,
            'technicians' => User::technicians()->active()->get(['id', 'first_name', 'last_name']),
            'statuses' => AppointmentStatus::cases(),
            'upcomingCount' => $upcomingCount,
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.appointments.create', [
            'leads' => Lead::select('id', 'first_name', 'last_name', 'email')
                ->latest()
                ->get(),
            'technicians' => User::technicians()->active()->get(['id', 'first_name', 'last_name']),
            'preselectedLeadId' => $request->integer('lead_id'),
        ]);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $this->service->create($request->validated(), $request->user());

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Cita creada correctamente.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $request->validate([
            'status' => ['required', 'in:pendiente,confirmada,realizada,cancelada'],
        ]);

        $this->service->updateStatus(
            $appointment,
            AppointmentStatus::from($request->status),
            $request->user()
        );

        return back()->with('success', 'Estado actualizado.');
    }
}
