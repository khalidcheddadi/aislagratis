<?php

namespace App\Policies;

use App\Models\Installation;
use App\Models\User;

class InstallationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->canManage();
    }

    public function view(User $user, Installation $installation): bool
    {
        return $user->role->canManage() || $user->id === $installation->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role->canManage();
    }

    public function update(User $user, Installation $installation): bool
    {
        return $user->isAdmin() || $user->isSales();
    }

    public function delete(User $user, Installation $installation): bool
    {
        return $user->isAdmin();
    }
}
