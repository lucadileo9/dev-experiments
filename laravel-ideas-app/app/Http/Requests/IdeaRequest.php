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
        // If the idea exists, check if the user can update it
        if ($idea = $this->route('idea')) {
            return $this->user()->can('update', $idea);
        }

        // Per la creazione, l'utente deve solo essere autenticato
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:5'],
            'description' => ['required', 'string', 'min:10'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'links' => ['nullable', 'array'],
            'links.*' => ['url'],
            'steps' => ['nullable', 'array'],
            'steps.*' => ['string'],
            'image' => ['nullable', 'image', 'max:2048'], // max 2MB
        ];
    }
}
