<?php

namespace App\Services;

use App\DTO\CategorieDTO;
use App\Models\Categorie;
use App\Repositories\Contracts\CategorieRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategorieService
{
    public function __construct(
        private readonly CategorieRepositoryInterface $categorieRepo,
    ) {}

    public function listerArbre(): Collection
    {
        return $this->categorieRepo->arbre();
    }

    public function listerPourSelecteur(): array
    {
        return $this->categorieRepo->listerPourSelecteur();
    }

    public function creer(CategorieDTO $dto): Categorie
    {
        $donnees = $dto->toArray();

        // Empêcher les cycles parentaux
        if ($dto->parentId) {
            $this->validerParent($dto->parentId);
        }

        return $this->categorieRepo->creer($donnees);
    }

    public function modifier(Categorie $categorie, CategorieDTO $dto): Categorie
    {
        // Empêcher qu'une catégorie devienne son propre ancêtre
        if ($dto->parentId && $dto->parentId !== $categorie->parent_id) {
            $this->validerParent($dto->parentId, $categorie->id);
        }

        return $this->categorieRepo->modifier($categorie, $dto->toArray());
    }

    public function supprimer(Categorie $categorie): void
    {
        if ($categorie->enfants()->count() > 0) {
            throw new \RuntimeException('Impossible de supprimer une catégorie ayant des sous-catégories.');
        }

        if ($categorie->ouvrages()->count() > 0) {
            throw new \RuntimeException('Impossible de supprimer une catégorie ayant des ouvrages associés.');
        }

        $this->categorieRepo->supprimer($categorie);
    }

    private function validerParent(int $parentId, ?int $categorieId = null): void
    {
        $parent = $this->categorieRepo->trouverParId($parentId);

        if (! $parent) {
            throw new \RuntimeException('La catégorie parente sélectionnée est introuvable.');
        }

        if ($categorieId && $parentId === $categorieId) {
            throw new \RuntimeException('Une catégorie ne peut pas être son propre parent.');
        }
    }
}
