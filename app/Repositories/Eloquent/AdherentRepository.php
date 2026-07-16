<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatutAdherent;
use App\Models\Adherent;
use App\Repositories\Contracts\AdherentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AdherentRepository implements AdherentRepositoryInterface
{
    public function all(): Collection
    {
        return Adherent::with('typeAdherent')->get();
    }

    public function find(int $id): ?Adherent
    {
        return Adherent::with('typeAdherent')->find($id);
    }

    public function findByNumCarte(string $numCarte): ?Adherent
    {
        return Adherent::where('num_carte', $numCarte)->first();
    }

    public function findByEmail(string $email): ?Adherent
    {
        return Adherent::where('email', $email)->first();
    }

    public function findByStatut(string $statut): Collection
    {
        return Adherent::where('statut', $statut)->with('typeAdherent')->get();
    }

    public function findExpired(): Collection
    {
        return Adherent::where('date_expiration', '<', now())
            ->where('statut', '!=', StatutAdherent::RADIE->value)
            ->with('typeAdherent')
            ->get();
    }

    public function findActif(): Collection
    {
        return Adherent::where('statut', StatutAdherent::ACTIF->value)
            ->where('date_expiration', '>=', now())
            ->with('typeAdherent')
            ->get();
    }

    public function canBorrow(int $adherentId): bool
    {
        $adherent = $this->find($adherentId);

        if (! $adherent) {
            return false;
        }

        if ($adherent->statut !== StatutAdherent::ACTIF) {
            return false;
        }

        if ($adherent->date_expiration->isPast()) {
            return false;
        }

        // Vérification du quota (sera complétée avec le module Prêts)
        // $pretsEnCours = $adherent->prets()->where('statut', 'en_cours')->count();
        // return $pretsEnCours < $adherent->typeAdherent->max_books;

        return true;
    }

    public function paginer(int $perPage = 15, array $filtres = []): LengthAwarePaginator
    {
        $query = Adherent::with('typeAdherent');

        if (! empty($filtres['recherche'])) {
            $recherche = $filtres['recherche'];
            $query->where(function ($q) use ($recherche) {
                $q->where('nom', 'LIKE', "%{$recherche}%")
                  ->orWhere('prenom', 'LIKE', "%{$recherche}%")
                  ->orWhere('email', 'LIKE', "%{$recherche}%")
                  ->orWhere('num_carte', 'LIKE', "%{$recherche}%");
            });
        }

        if (! empty($filtres['statut'])) {
            $query->where('statut', $filtres['statut']);
        }

        if (! empty($filtres['type_adherent_id'])) {
            $query->where('type_adherent_id', $filtres['type_adherent_id']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function create(array $data): Adherent
    {
        return Adherent::create($data);
    }

    public function update(Adherent $adherent, array $data): bool
    {
        return $adherent->update($data);
    }

    public function delete(Adherent $adherent): bool
    {
        return $adherent->delete();
    }
}
