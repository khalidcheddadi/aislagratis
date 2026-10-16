<?php

namespace App\Http\Requests\Public;

use App\Enums\AccessType;
use App\Enums\PropertyType;
use App\Rules\ReCaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc,dns', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9\s\+\-\(\)]{6,30}$/'],
            'postal_code' => ['required', 'string', 'regex:/^\d{5}$/'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'property_type' => ['required', Rule::enum(PropertyType::class)],
            'area_m2' => ['nullable', 'numeric', 'min:1', 'max:99999'],
            'year_built' => ['nullable', 'integer', 'digits:4', 'min:1800', 'max:'.date('Y')],
            'has_attic' => ['boolean'],
            'has_basement' => ['boolean'],
            'access_type' => ['nullable', Rule::enum(AccessType::class)],
            'message' => ['nullable', 'string', 'max:2000'],
            'service_id' => ['nullable', 'integer', 'exists:services,id'],
            'g-recaptcha-response' => [
                app()->environment('production') ? new ReCaptcha : 'nullable',
            ],
            'privacy' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'Los apellidos son obligatorios.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Introduce un email válido.',
            'postal_code.required' => 'El código postal es obligatorio.',
            'postal_code.regex' => 'El código postal debe tener 5 dígitos.',
            'property_type.required' => 'Selecciona un tipo de inmueble.',
            'property_type.Illuminate\Validation\Rules\Enum' => 'Tipo de inmueble no válido.',
            'privacy.accepted' => 'Debes aceptar la política de privacidad.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name' => trim((string) $this->first_name),
            'last_name' => trim((string) $this->last_name),
            'email' => strtolower(trim((string) $this->email)),
            'postal_code' => trim((string) $this->postal_code),
            'has_attic' => $this->boolean('has_attic'),
            'has_basement' => $this->boolean('has_basement'),
        ]);
    }
}
