<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'plate_number' => ['required', 'string', 'max:20', Rule::unique('vehicles')->ignore($this->vehicle)],
            'model' => 'required|string|max:255',
            'insurance_expiry' => 'required|date',
            'inspection_expiry' => 'required|date',
            'circulation_card' => 'nullable|file|mimes:pdf|max:10240',
            'notes' => 'nullable|string',
        ];
    }
}