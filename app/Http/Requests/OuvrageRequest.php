<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OuvrageRequest extends FormRequest
{
    public function authorize(): bool
    {
        $ouvrage = $this->route('ouvrage');
        if ($ouvrage) {
            return $this->user()->can('update', $ouvrage);
        }
        return $this->user()->can('create', \App\Models\Ouvrage::class);
    }

    public function rules(): array
    {
        $ouvrageId = $this->route('ouvrage')?->id;

        return [
            'titre'                  => ['required', 'string', 'max:255'],
            'slug'                   => [
                'nullable',
                'string',
                'max:265',
                Rule::unique('ouvrages', 'slug')->ignore($ouvrageId),
            ],
            'isbn'                   => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('ouvrages', 'isbn')->ignore($ouvrageId),
            ],
            'auteurs'                => ['required', 'string', 'max:500'],
            'editeur'                => ['nullable', 'string', 'max:150'],
            'langue'                 => ['nullable', 'string', 'max:50'],
            'annee_publication'      => ['nullable', 'integer', 'min:1000', 'max:' . date('Y')],
            'description'            => ['nullable', 'string', 'max:5000'],
            'image_couverture'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'nombre_pages'           => ['nullable', 'integer', 'min:1', 'max:99999'],
            'format'                 => ['nullable', 'string', 'max:50'],
            'actif'                  => ['nullable', 'boolean'],
            'categories'             => ['nullable', 'array'],
            'categories.*'           => ['integer', Rule::exists('categories', 'id')],
            'categorie_principale_id'=> ['nullable', 'integer', Rule::exists('categories', 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required'              => 'Le titre de l\'ouvrage est obligatoire.',
            'titre.max'                   => 'Le titre ne peut pas dépasser 255 caractères.',
            'auteurs.required'            => 'Le champ auteurs est obligatoire.',
            'isbn.unique'                 => 'Cet ISBN est déjà enregistré pour un autre ouvrage.',
            'slug.unique'                 => 'Ce slug est déjà utilisé par un autre ouvrage.',
            'annee_publication.integer'   => 'L\'année de publication doit être un nombre entier.',
            'annee_publication.min'       => 'L\'année de publication semble incorrecte.',
            'annee_publication.max'       => 'L\'année de publication ne peut pas être dans le futur.',
            'image_couverture.image'      => 'Le fichier doit être une image.',
            'image_couverture.max'        => 'L\'image ne peut pas dépasser 2 Mo.',
            'categories.*.exists'         => 'Une catégorie sélectionnée est invalide.',
        ];
    }
}
