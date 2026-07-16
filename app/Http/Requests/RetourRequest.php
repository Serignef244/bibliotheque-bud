<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RetourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bibliothecaire'));
    }

    public function rules(): array
    {
        return [
            'pret_id' => 'required|exists:prets,id',
            'date_retour' => 'required|date',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $pret = \App\Models\Pret::find($this->input('pret_id'));
            if ($pret && $pret->statut === 'rendu') {
                $validator->errors()->add('pret_id', 'Ce prêt a déjà été rendu');
            }
        });
    }

    public function messages(): array
    {
        return [
            'pret_id.required' => 'Le prêt est requis',
            'pret_id.exists' => 'Le prêt n\'existe pas',
            'date_retour.required' => 'La date de retour est requise',
            'date_retour.date' => 'La date de retour doit être une date valide',
        ];
    }
}
