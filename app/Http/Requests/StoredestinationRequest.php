<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoredestinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'image'         => 'nullable|string|max:255',
            'itineraire_id' => 'required|exists:itineraires,id',
        ];
    }
}
