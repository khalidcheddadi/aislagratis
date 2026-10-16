<?php

namespace App\Actions\Leads;

use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\LeadStatusChangedNotification;
use Illuminate\Validation\ValidationException;

class UpdateLeadStatusAction
{
    public function execute(Lead $lead, LeadStatus $newStatus, User $user): Lead
    {

        if (! $lead->status->canTransitionTo($newStatus) && ! $user->isAdmin()) {
            throw ValidationException::withMessages([
                'status' => "No se puede cambiar de {$lead->status->label()} a {$newStatus->label()}.",
            ]);
        }

        $oldStatus = $lead->status;

        $lead->update([
            'status' => $newStatus,
            'contacted_at' => $newStatus === LeadStatus::CONTACTED && ! $lead->contacted_at
                ? now()
                : $lead->contacted_at,
        ]);

        if ($lead->user_id && $lead->user) {
            $lead->user->notify(
                new LeadStatusChangedNotification($lead, $oldStatus, $newStatus)
            );
        }

        activity()
            ->performedOn($lead)
            ->causedBy($user)
            ->withProperties([
                'old_status' => $oldStatus->value,
                'new_status' => $newStatus->value,
            ])
            ->log('Estado de lead actualizado');

        return $lead->fresh();
    }
}
