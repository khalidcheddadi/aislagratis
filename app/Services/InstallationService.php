<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Enums\InstallationStatus;
use App\Enums\LeadStatus;
use App\Models\Installation;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InstallationService
{
    public function paginate(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return Installation::query()
            ->with([
                'user:id,first_name,last_name',
                'service:id,name',
                'appointment',
            ])
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['service_id'] ?? null, fn ($q, $v) => $q->where('service_id', $v))
            ->orderByDesc('installation_date')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data, User $user): Installation
    {
        return DB::transaction(function () use ($data, $user) {
            $installation = Installation::create($data);

            if (! empty($data['appointment_id'])) {
                $appointment = $installation->appointment;
                $appointment?->update(['status' => AppointmentStatus::COMPLETED]);
                $appointment?->lead?->update([
                    'status' => LeadStatus::COMPLETED,
                    'converted_at' => now(),
                ]);
            }

            activity()
                ->performedOn($installation)
                ->causedBy($user)
                ->log('Instalación registrada');

            return $installation->fresh(['user', 'service']);
        });
    }

    public function updateStatus(
        Installation $installation,
        InstallationStatus $status,
        User $user
    ): Installation {
        $installation->update(['status' => $status]);

        activity()
            ->performedOn($installation)
            ->causedBy($user)
            ->withProperties(['status' => $status->value])
            ->log('Estado de instalación actualizado');

        return $installation;
    }
}
