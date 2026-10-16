<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->canManage() || $user->isTechnician();
    }

    public function view(User $user, Appointment $appointment): bool
    {
        return $user->role->canManage()
            || $user->isTechnician()
            || $user->id === $appointment->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role->canManage();
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return $user->role->canManage()
            || $user->id === $appointment->technician_id;
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->isAdmin();
    }
}
