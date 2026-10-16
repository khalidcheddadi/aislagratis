<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Enums\LeadStatus;
use App\Models\Appointment;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\AppointmentScheduledNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function paginate(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return Appointment::query()
            ->with([
                'lead:id,first_name,last_name,email,phone,address,city',
                'technician:id,first_name,last_name',
            ])
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['technician_id'] ?? null, fn ($q, $v) => $q->forTechnician((int) $v))
            ->when($filters['date'] ?? null, fn ($q, $v) => $q->whereDate('appointment_date', $v))
            ->orderByDesc('appointment_date')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data, User $user): Appointment
    {
        return DB::transaction(function () use ($data, $user) {
            $lead = Lead::findOrFail($data['lead_id']);

            $appointment = Appointment::create([
                'lead_id' => $lead->id,
                'user_id' => $lead->user_id,
                'technician_id' => $data['technician_id'] ?? null,
                'appointment_date' => $data['appointment_date'],
                'duration_minutes' => $data['duration_minutes'] ?? 60,
                'status' => AppointmentStatus::PENDING,
                'notes' => $data['notes'] ?? null,
            ]);

            if (in_array($lead->status, [LeadStatus::NEW, LeadStatus::CONTACTED], true)) {
                $lead->update(['status' => LeadStatus::SCHEDULED]);
            }

            if ($appointment->technician_id) {
                $appointment->technician->notify(
                    new AppointmentScheduledNotification($appointment, 'assigned')
                );
            }
            if ($appointment->user_id) {
                $appointment->user->notify(
                    new AppointmentScheduledNotification($appointment, 'scheduled')
                );
            }

            activity()
                ->performedOn($appointment)
                ->causedBy($user)
                ->log('Cita creada');

            return $appointment->fresh(['lead', 'technician']);
        });
    }

    public function updateStatus(
        Appointment $appointment,
        AppointmentStatus $status,
        User $user
    ): Appointment {
        return DB::transaction(function () use ($appointment, $status, $user) {
            $appointment->update(['status' => $status]);

            if ($status === AppointmentStatus::COMPLETED && $appointment->lead) {
                $appointment->lead->update([
                    'status' => LeadStatus::COMPLETED,
                    'converted_at' => now(),
                ]);
            }

            activity()
                ->performedOn($appointment)
                ->causedBy($user)
                ->withProperties(['status' => $status->value])
                ->log('Estado de cita actualizado');

            return $appointment->fresh();
        });
    }
}
