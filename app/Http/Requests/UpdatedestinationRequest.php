<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatedestinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'sometimes|string|max:255',
            'description'   => 'sometimes|string',
            'image'         => 'sometimes|nullable|string|max:255',
            'itineraire_id' => 'sometimes|exists:itineraires,id',
        ];
    }
}
