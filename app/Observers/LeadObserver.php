<?php

namespace App\Observers;

use App\Enums\UserRole;
use App\Events\LeadCreated;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Support\Facades\Cache;

class LeadObserver
{
    public function created(Lead $lead): void
    {

        Cache::forget('leads.stats');
        Cache::forget('dashboard.admin.stats');

        event(new LeadCreated($lead));

        User::query()
            ->active()
            ->whereIn('role', [UserRole::ADMIN->value, UserRole::SALES->value])
            ->each(fn (User $user) => $user->notify(new NewLeadNotification($lead)));
    }

    public function updated(Lead $lead): void
    {
        if ($lead->wasChanged('status')) {
            Cache::forget('leads.stats');
            Cache::forget('dashboard.admin.stats');
        }
    }

    public function deleted(Lead $lead): void
    {
        Cache::forget('leads.stats');
        Cache::forget('dashboard.admin.stats');
    }
}
