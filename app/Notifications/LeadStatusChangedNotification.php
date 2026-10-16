<?php

namespace App\Notifications;

use App\Enums\LeadStatus;
use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class LeadStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Lead $lead,
        public LeadStatus $oldStatus,
        public LeadStatus $newStatus,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'lead_status_changed',
            'lead_id' => $this->lead->id,
            'title' => 'Actualización de tu solicitud',
            'message' => "Tu solicitud ha pasado a estado: {$this->newStatus->label()}",
            'url' => route('customer.leads.show', $this->lead),
        ];
    }
}
