<?php

namespace App\Repositories\Contracts;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Collection;

interface CategorieRepositoryInterface
{
    public function tous(): Collection;

    public function racines(): Collection;

    public function arbre(): Collection;

    public function trouverParId(int $id): ?Categorie;

    public function trouverParSlug(string $slug): ?Categorie;

    public function creer(array $donnees): Categorie;

    public function modifier(Categorie $categorie, array $donnees): Categorie;

    public function supprimer(Categorie $categorie): bool;

    public function listerPourSelecteur(): array;
}
