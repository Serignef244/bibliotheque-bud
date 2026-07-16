<?php

namespace App\Repositories\Contracts;

use App\Models\Ouvrage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface OuvrageRepositoryInterface
{
    public function paginer(int $perPage = 15, array $filtres = []): LengthAwarePaginator;

    public function tous(): Collection;

    public function trouverParId(int $id): ?Ouvrage;

    public function trouverParSlug(string $slug): ?Ouvrage;

    public function trouverParIsbn(string $isbn): ?Ouvrage;

    public function creer(array $donnees): Ouvrage;

    public function modifier(Ouvrage $ouvrage, array $donnees): Ouvrage;

    public function supprimer(Ouvrage $ouvrage): bool;

    public function rechercherParTerme(string $terme): Collection;

    public function synchroniserCategories(Ouvrage $ouvrage, array $categories, ?int $categoriePrincipaleId): void;
}
