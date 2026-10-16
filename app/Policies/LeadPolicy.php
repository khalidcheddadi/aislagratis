<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->canManage();
    }

    public function view(User $user, Lead $lead): bool
    {
        return $user->role->canManage() || $user->id === $lead->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Lead $lead): bool
    {
        return $user->isAdmin() || $user->isSales();
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $user->isAdmin();
    }

    public function export(User $user): bool
    {
        return $user->role->canManage();
    }
}
