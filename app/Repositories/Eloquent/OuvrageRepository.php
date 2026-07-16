<?php

namespace App\Repositories\Eloquent;

use App\Models\Ouvrage;
use App\Repositories\Contracts\OuvrageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OuvrageRepository implements OuvrageRepositoryInterface
{
    public function paginer(int $perPage = 15, array $filtres = []): LengthAwarePaginator
    {
        $query = Ouvrage::with(['categories'])
            ->when(! empty($filtres['recherche']), fn ($q) => $q->recherche($filtres['recherche']))
            ->when(! empty($filtres['categorie_id']), fn ($q) => $q->parCategorie($filtres['categorie_id']))
            ->when(isset($filtres['actif']), fn ($q) => $q->where('actif', $filtres['actif']))
            ->when(isset($filtres['disponible']) && $filtres['disponible'], fn ($q) => $q->disponible());

        $tri = $filtres['tri'] ?? 'titre';
        $ordre = $filtres['ordre'] ?? 'asc';
        $query->orderBy($tri, $ordre);

        return $query->paginate($perPage)->withQueryString();
    }

    public function tous(): Collection
    {
        return Ouvrage::with(['categories'])->actif()->orderBy('titre')->get();
    }

    public function trouverParId(int $id): ?Ouvrage
    {
        return Ouvrage::with(['categories', 'exemplaires'])->find($id);
    }

    public function trouverParSlug(string $slug): ?Ouvrage
    {
        return Ouvrage::with(['categories', 'exemplaires'])->where('slug', $slug)->first();
    }

    public function trouverParIsbn(string $isbn): ?Ouvrage
    {
        return Ouvrage::where('isbn', $isbn)->first();
    }

    public function creer(array $donnees): Ouvrage
    {
        return Ouvrage::create($donnees);
    }

    public function modifier(Ouvrage $ouvrage, array $donnees): Ouvrage
    {
        $ouvrage->update($donnees);
        return $ouvrage->fresh(['categories', 'exemplaires']);
    }

    public function supprimer(Ouvrage $ouvrage): bool
    {
        return (bool) $ouvrage->delete();
    }

    public function rechercherParTerme(string $terme): Collection
    {
        return Ouvrage::with(['categories'])
            ->actif()
            ->recherche($terme)
            ->limit(20)
            ->get();
    }

    public function synchroniserCategories(Ouvrage $ouvrage, array $categories, ?int $categoriePrincipaleId): void
    {
        $pivot = [];
        foreach ($categories as $categorieId) {
            $pivot[$categorieId] = ['principale' => ($categorieId === $categoriePrincipaleId)];
        }
        $ouvrage->categories()->sync($pivot);
    }
}
