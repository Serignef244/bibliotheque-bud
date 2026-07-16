<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatutAdherent;
use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Models\Pret;
use App\Repositories\Interfaces\PretRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PretRepository implements PretRepositoryInterface
{
    public function all(): Collection
    {
        return Pret::with(['adherent', 'exemplaire.ouvrage'])->get();
    }

    public function find(int $id): ?Pret
    {
        return Pret::with(['adherent', 'exemplaire.ouvrage', 'historiques', 'penalite'])->find($id);
    }

    public function create(array $data): Pret
    {
        return Pret::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return Pret::find($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return Pret::find($id)->delete();
    }

    public function getCurrentLoans(): Collection
    {
        return Pret::with(['adherent', 'exemplaire.ouvrage'])
            ->enCours()
            ->orderBy('date_retour_prevue')
            ->get();
    }

    public function getLateLoans(): Collection
    {
        return Pret::with(['adherent', 'exemplaire.ouvrage'])
            ->enRetard()
            ->orderBy('date_retour_prevue')
            ->get();
    }

    public function getByAdherent(int $adherentId): Collection
    {
        return Pret::with(['exemplaire.ouvrage'])
            ->where('adherent_id', $adherentId)
            ->orderBy('date_emprunt', 'desc')
            ->get();
    }

    public function getByExemplaire(int $exemplaireId): Collection
    {
        return Pret::with(['adherent'])
            ->where('exemplaire_id', $exemplaireId)
            ->orderBy('date_emprunt', 'desc')
            ->get();
    }

    public function getHistory(int $adherentId): Collection
    {
        return Pret::with(['exemplaire.ouvrage', 'penalite'])
            ->where('adherent_id', $adherentId)
            ->where('statut', 'rendu')
            ->orderBy('date_retour_reelle', 'desc')
            ->get();
    }

    public function findActiveByExemplaire(int $exemplaireId): ?Pret
    {
        return Pret::where('exemplaire_id', $exemplaireId)
            ->whereIn('statut', ['en_cours', 'retard'])
            ->first();
    }

    public function countCurrentByAdherent(int $adherentId): int
    {
        return Pret::where('adherent_id', $adherentId)
            ->whereIn('statut', ['en_cours', 'retard'])
            ->count();
    }

    public function canBorrow(int $adherentId): bool
    {
        $adherent = Adherent::with('typeAdherent')->find($adherentId);
        if (!$adherent) {
            return false;
        }

        $statutAdherent = $adherent->statut;
        $estActif = $statutAdherent instanceof StatutAdherent
            ? $statutAdherent === StatutAdherent::ACTIF
            : $statutAdherent === StatutAdherent::ACTIF->value;

        if (! $estActif) {
            return false;
        }

        $currentLoans = $this->countCurrentByAdherent($adherentId);
        $maxBooks = $adherent->typeAdherent->max_books ?? 0;

        return $currentLoans < $maxBooks;
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Pret::with(['adherent', 'exemplaire.ouvrage']);

        if (isset($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (isset($filters['adherent_id'])) {
            $query->where('adherent_id', $filters['adherent_id']);
        }

        if (isset($filters['recherche'])) {
            $recherche = $filters['recherche'];
            $query->whereHas('adherent', function ($q) use ($recherche) {
                $q->where('nom', 'LIKE', "%{$recherche}%")
                    ->orWhere('prenom', 'LIKE', "%{$recherche}%")
                    ->orWhere('num_carte', 'LIKE', "%{$recherche}%");
            })->orWhereHas('exemplaire.ouvrage', function ($q) use ($recherche) {
                $q->where('titre', 'LIKE', "%{$recherche}%")
                    ->orWhere('auteur', 'LIKE', "%{$recherche}%");
            });
        }

        if (isset($filters['date_debut'])) {
            $query->where('date_emprunt', '>=', $filters['date_debut']);
        }

        if (isset($filters['date_fin'])) {
            $query->where('date_emprunt', '<=', $filters['date_fin']);
        }

        return $query->orderBy('date_emprunt', 'desc')->paginate($perPage);
    }
}
