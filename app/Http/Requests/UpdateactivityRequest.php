<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateactivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'            => 'sometimes|string|max:255',
            'destination_id' => 'sometimes|exists:destinations,id',
        ];
    }
}
