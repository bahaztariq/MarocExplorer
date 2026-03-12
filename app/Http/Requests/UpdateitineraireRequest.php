<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateitineraireRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'    => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'duration' => 'sometimes|string|max:255',
            'image'    => 'sometimes|string|max:255',
        ];
    }
}
