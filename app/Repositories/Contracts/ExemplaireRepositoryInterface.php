<?php

namespace App\Repositories\Contracts;

use App\Enums\StatutExemplaire;
use App\Models\Exemplaire;
use Illuminate\Database\Eloquent\Collection;

interface ExemplaireRepositoryInterface
{
    public function parOuvrage(int $ouvrageId): Collection;

    public function trouverParId(int $id): ?Exemplaire;

    public function trouverParCodeBarre(string $codeBarre): ?Exemplaire;

    public function creer(array $donnees): Exemplaire;

    public function modifier(Exemplaire $exemplaire, array $donnees): Exemplaire;

    public function supprimer(Exemplaire $exemplaire): bool;

    public function changerStatut(Exemplaire $exemplaire, StatutExemplaire $statut): Exemplaire;

    public function genererCodeBarre(int $ouvrageId): string;

    public function nombreDisponiblesParOuvrage(int $ouvrageId): int;
}
