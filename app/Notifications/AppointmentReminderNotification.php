<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⏰ Recordatorio: cita mañana')
            ->greeting("Hola {$notifiable->first_name}")
            ->line('Te recordamos tu cita programada para mañana.')
            ->line('Fecha: '.$this->appointment->appointment_date->translatedFormat('d M Y H:i'))
            ->action('Ver detalles', route('admin.appointments.index'))
            ->salutation('Saludos, '.config('app.name'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'appointment_reminder',
            'appointment_id' => $this->appointment->id,
            'title' => 'Recordatorio de cita',
            'message' => 'Cita mañana a las '.$this->appointment->appointment_date->format('H:i'),
            'url' => route('admin.appointments.index'),
        ];
    }
}
