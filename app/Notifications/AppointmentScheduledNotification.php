<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentScheduledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Appointment $appointment,
        public string $context = 'scheduled',
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $greeting = $notifiable instanceof User ? $notifiable->first_name : 'Cliente';

        return (new MailMessage)
            ->subject('📅 Nueva cita programada')
            ->greeting("Hola {$greeting}")
            ->line('Se ha programado una nueva cita.')
            ->line('Fecha: '.$this->appointment->appointment_date->translatedFormat('d M Y H:i'))
            ->line('Duración: '.$this->appointment->duration_minutes.' min')
            ->when($this->appointment->lead, fn ($mail) => $mail->line("Cliente: {$this->appointment->lead->full_name}")
            )
            ->action('Ver cita', route('admin.appointments.index'))
            ->salutation('Saludos, '.config('app.name'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'appointment_scheduled',
            'appointment_id' => $this->appointment->id,
            'title' => 'Nueva cita programada',
            'message' => 'Fecha: '.$this->appointment->appointment_date->format('d/m/Y H:i'),
            'url' => route('admin.appointments.index'),
        ];
    }
}
