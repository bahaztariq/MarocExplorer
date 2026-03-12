<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoredishRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'description'    => 'required|string',
            'image'          => 'nullable|string|max:255',
            'destination_id' => 'required|exists:destinations,id',
        ];
    }
}
