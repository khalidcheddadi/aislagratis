<?php

namespace App\Http\Resources;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Appointment */
class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'appointment_date' => $this->appointment_date->toIso8601String(),
            'appointment_date_human' => $this->appointment_date->translatedFormat('d M Y H:i'),
            'duration_minutes' => $this->duration_minutes,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],
            'lead' => new LeadResource($this->whenLoaded('lead')),
            'technician' => $this->whenLoaded('technician', fn () => [
                'id' => $this->technician->id,
                'name' => $this->technician->full_name,
            ]),
            'notes' => $this->notes,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
