<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('appointments.create');
    }

    public function rules(): array
    {
        return [
            'lead_id' => ['required', 'exists:leads,id'],
            'technician_id' => ['nullable', 'exists:users,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:480'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'lead_id.required' => 'El lead es obligatorio.',
            'appointment_date.required' => 'La fecha es obligatoria.',
            'appointment_date.after_or_equal' => 'La fecha debe ser hoy o posterior.',
        ];
    }
}
