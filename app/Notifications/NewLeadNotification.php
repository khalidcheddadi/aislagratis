<?php

namespace App\Notifications;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Lead $lead) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("🚀 Nuevo lead: {$this->lead->full_name}")
            ->greeting("Hola {$notifiable->first_name}")
            ->line('Se ha recibido un nuevo lead.')
            ->line("Cliente: {$this->lead->full_name}")
            ->line("Email: {$this->lead->email}")
            ->line('Teléfono: '.($this->lead->phone ?? 'N/D'))
            ->line("Ubicación: {$this->lead->location}")
            ->action('Ver lead', route('admin.leads.show', $this->lead))
            ->salutation('Saludos, '.config('app.name'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'lead_created',
            'lead_id' => $this->lead->id,
            'title' => 'Nuevo lead recibido',
            'message' => "{$this->lead->full_name} - {$this->lead->location}",
            'url' => route('admin.leads.show', $this->lead),
        ];
    }
}
