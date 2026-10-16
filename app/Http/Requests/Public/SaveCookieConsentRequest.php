<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCookieConsentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'consent' => ['required', Rule::in(['accepted', 'rejected'])],
            'visitor_token' => ['required', 'string', 'min:10', 'max:64'],
        ];
    }
}
