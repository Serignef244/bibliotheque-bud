<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeAdherentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $typeAdherentId = $this->route('types_adherent')?->id ?? $this->route('types_adherent');

        return [
            'nom' => [
                'required',
                'string',
                'max:100',
                'unique:type_adherents,nom,' . $typeAdherentId,
            ],
            'duree_jours' => ['required', 'integer', 'min:1'],
            'max_books' => ['required', 'integer', 'min:1'],
            'tarif_penalite' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du type est obligatoire.',
            'nom.unique' => 'Ce nom de type existe déjà.',
            'duree_jours.required' => 'La durée de validité est obligatoire.',
            'duree_jours.min' => 'La durée doit être d\'au moins 1 jour.',
            'max_books.required' => 'Le nombre max d\'emprunts est obligatoire.',
            'max_books.min' => 'Au moins 1 emprunt doit être autorisé.',
            'tarif_penalite.required' => 'Le tarif de pénalité est obligatoire.',
            'tarif_penalite.min' => 'Le tarif ne peut pas être négatif.',
        ];
    }
}
