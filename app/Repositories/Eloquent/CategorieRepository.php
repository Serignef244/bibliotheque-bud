<?php

namespace App\Repositories\Eloquent;

use App\Models\Categorie;
use App\Repositories\Contracts\CategorieRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategorieRepository implements CategorieRepositoryInterface
{
    public function tous(): Collection
    {
        return Categorie::actif()->ordonnes()->get();
    }

    public function racines(): Collection
    {
        return Categorie::actif()->racines()->ordonnes()->with('enfants')->get();
    }

    public function arbre(): Collection
    {
        return Categorie::actif()
            ->racines()
            ->ordonnes()
            ->with('descendants')
            ->get();
    }

    public function trouverParId(int $id): ?Categorie
    {
        return Categorie::with(['parent', 'enfants'])->find($id);
    }

    public function trouverParSlug(string $slug): ?Categorie
    {
        return Categorie::where('slug', $slug)->first();
    }

    public function creer(array $donnees): Categorie
    {
        return Categorie::create($donnees);
    }

    public function modifier(Categorie $categorie, array $donnees): Categorie
    {
        $categorie->update($donnees);
        return $categorie->fresh();
    }

    public function supprimer(Categorie $categorie): bool
    {
        return (bool) $categorie->delete();
    }

    public function listerPourSelecteur(): array
    {
        return Categorie::actif()
            ->ordonnes()
            ->get(['id', 'nom', 'parent_id'])
            ->map(fn ($c) => ['id' => $c->id, 'label' => $c->nom_complet])
            ->toArray();
    }
}
