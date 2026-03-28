<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IdeaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'La descrizione dell\'idea è obbligatoria.',
            'description.string' => 'La descrizione deve essere testo.',
            'description.min' => 'La descrizione deve contenere almeno 10 caratteri.',
            'description.max' => 'La descrizione non può superare i 1000 caratteri.',
        ];
    }
}
