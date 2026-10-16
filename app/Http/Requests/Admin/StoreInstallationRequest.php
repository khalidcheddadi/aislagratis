<?php

namespace App\Http\Requests\Admin;

use App\Enums\InstallationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInstallationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('installations.create');
    }

    public function rules(): array
    {
        return [
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'user_id' => ['required', 'exists:users,id'],
            'service_id' => ['required', 'exists:services,id'],
            'installation_date' => ['required', 'date'],
            'total_cost' => ['required', 'numeric', 'min:0'],
            'subsidy_amount' => ['required', 'numeric', 'min:0', 'lte:total_cost'],
            'status' => ['required', Rule::enum(InstallationStatus::class)],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
