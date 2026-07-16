<?php

namespace App\Http\Requests;

use App\Enums\StatutExemplaire;
use App\Models\Exemplaire;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExemplaireRequest extends FormRequest
{
    public function authorize(): bool
    {
        $exemplaire = $this->route('exemplaire');

        if ($exemplaire instanceof Exemplaire) {
            return $this->user()?->can('update', $exemplaire) ?? false;
        }

        return $this->user()?->can('create', Exemplaire::class) ?? false;
    }

    public function rules(): array
    {
        $exemplaireId = $this->route('exemplaire')?->id;

        return [
            'ouvrage_id'       => ['required', 'integer', Rule::exists('ouvrages', 'id')],
            'code_barre'       => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('exemplaires', 'code_barre')->ignore($exemplaireId),
            ],
            'cote'             => ['nullable', 'string', 'max:50'],
            'statut'           => ['nullable', 'string', Rule::in(StatutExemplaire::values())],
            'date_acquisition' => ['nullable', 'date', 'before_or_equal:today'],
            'prix_acquisition' => ['nullable', 'numeric', 'min:0', 'max:9999999'],
            'fournisseur'      => ['nullable', 'string', 'max:150'],
            'notes'            => ['nullable', 'string', 'max:2000'],
            'etat'             => ['nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'ouvrage_id.required'      => 'L\'ouvrage associé est obligatoire.',
            'ouvrage_id.exists'        => 'L\'ouvrage sélectionné est introuvable.',
            'code_barre.unique'        => 'Ce code-barres est déjà utilisé par un autre exemplaire.',
            'statut.in'                => 'Le statut sélectionné est invalide.',
            'date_acquisition.date'    => 'La date d\'acquisition est invalide.',
            'date_acquisition.before_or_equal' => 'La date d\'acquisition ne peut pas être dans le futur.',
            'prix_acquisition.numeric' => 'Le prix doit être un nombre.',
            'prix_acquisition.min'     => 'Le prix ne peut pas être négatif.',
            'etat.min'                 => 'L\'état doit être compris entre 1 (mauvais) et 5 (neuf).',
            'etat.max'                 => 'L\'état doit être compris entre 1 (mauvais) et 5 (neuf).',
        ];
    }
}
