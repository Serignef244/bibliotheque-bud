<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatutExemplaire;
use App\Models\Exemplaire;
use App\Repositories\Contracts\ExemplaireRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ExemplaireRepository implements ExemplaireRepositoryInterface
{
    public function parOuvrage(int $ouvrageId): Collection
    {
        return Exemplaire::where('ouvrage_id', $ouvrageId)
            ->orderBy('code_barre')
            ->get();
    }

    public function trouverParId(int $id): ?Exemplaire
    {
        return Exemplaire::with('ouvrage')->find($id);
    }

    public function trouverParCodeBarre(string $codeBarre): ?Exemplaire
    {
        return Exemplaire::with('ouvrage')
            ->parCodeBarre($codeBarre)
            ->first();
    }

    public function creer(array $donnees): Exemplaire
    {
        return Exemplaire::create($donnees);
    }

    public function modifier(Exemplaire $exemplaire, array $donnees): Exemplaire
    {
        $exemplaire->update($donnees);
        return $exemplaire->fresh('ouvrage');
    }

    public function supprimer(Exemplaire $exemplaire): bool
    {
        return (bool) $exemplaire->delete();
    }

    public function changerStatut(Exemplaire $exemplaire, StatutExemplaire $statut): Exemplaire
    {
        $exemplaire->update(['statut' => $statut->value]);
        return $exemplaire->fresh();
    }

    public function genererCodeBarre(int $ouvrageId): string
    {
        // Format : BUD-<ouvrageId padded 6>-<séquence padded 4>
        $dernier = Exemplaire::where('ouvrage_id', $ouvrageId)
            ->withTrashed()
            ->count();

        return sprintf('BUD-%06d-%04d', $ouvrageId, $dernier + 1);
    }

    public function nombreDisponiblesParOuvrage(int $ouvrageId): int
    {
        return Exemplaire::where('ouvrage_id', $ouvrageId)
            ->disponible()
            ->count();
    }
}
