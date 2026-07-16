<?php

namespace App\Http\Requests;

use App\Models\Categorie;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategorieRequest extends FormRequest
{
    public function authorize(): bool
    {
        $categorie = $this->route('categorie');

        if ($categorie instanceof Categorie) {
            return $this->user()?->can('update', $categorie) ?? false;
        }

        // Le contrôle d'autorisation principal est effectué dans le contrôleur
        // via Gate::authorize(). Ici, on autorise la requête pour permettre
        // au contrôleur d'appliquer la politique. Cela évite un 403 rendu
        // par le FormRequest quand la vérification de l'utilisateur échoue
        // prématurément (ex : contexte AJAX / binding de route).
        return true;
    }

    public function rules(): array
    {
        $categorieId = $this->route('categorie')?->id;

        return [
            'nom'         => ['required', 'string', 'max:150'],
            'slug'        => [
                'nullable',
                'string',
                'max:160',
                Rule::unique('categories', 'slug')->ignore($categorieId),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'parent_id'   => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
                // Empêcher le cycle : le parent ne peut pas être soi-même
                function ($attr, $value, $fail) use ($categorieId) {
                    if ($categorieId && (int) $value === $categorieId) {
                        $fail('Une catégorie ne peut pas être son propre parent.');
                    }
                },
            ],
            'ordre'       => ['nullable', 'integer', 'min:0'],
            'actif'       => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'       => 'Le nom de la catégorie est obligatoire.',
            'nom.max'            => 'Le nom ne peut pas dépasser 150 caractères.',
            'slug.unique'        => 'Ce slug est déjà utilisé par une autre catégorie.',
            'parent_id.exists'   => 'La catégorie parente sélectionnée est introuvable.',
        ];
    }
}
