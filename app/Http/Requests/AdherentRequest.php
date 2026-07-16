<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdherentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adherentId = $this->route('adherent')?->id ?? $this->route('adherent');

        return [
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'unique:adherents,email,' . $adherentId,
            ],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'date_naissance' => ['nullable', 'date'],
            'type_adherent_id' => ['required', 'exists:type_adherents,id'],
            'statut' => ['nullable', 'in:actif,suspendu,expire,radie'],
            'motif_radiation' => ['nullable', 'string', 'required_if:statut,radie'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
            'type_adherent_id.required' => 'Le type d\'adhérent est obligatoire.',
            'type_adherent_id.exists' => 'Le type d\'adhérent sélectionné n\'existe pas.',
            'motif_radiation.required_if' => 'Le motif de radiation est obligatoire pour une radiation.',
        ];
    }
}
