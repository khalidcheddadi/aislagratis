<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $serviceId = $this->route('service')?->id;

        return [
            'name' => [
                'required', 'string', 'max:150',
                Rule::unique('services', 'name')->ignore($serviceId),
            ],
            'description' => ['required', 'string', 'max:1000'],
            'long_description' => ['nullable', 'string'],
            'icon_class' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'max:2048'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'estimated_hours' => ['required', 'integer', 'min:1', 'max:999'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:200'],
            'sort_order' => ['integer', 'min:0'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
        ];
    }
}
