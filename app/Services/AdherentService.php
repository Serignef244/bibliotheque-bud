<?php

namespace App\Services;

use App\DTO\AdherentDTO;
use App\Enums\StatutAdherent;
use App\Events\AdherentInscrit;
use App\Models\Adherent;
use App\Repositories\Contracts\AdherentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\CompteAdherentCree;

class AdherentService
{
    public function __construct(
        private readonly AdherentRepositoryInterface $repository,
    ) {}

    public function paginer(int $perPage = 15, array $filtres = []): LengthAwarePaginator
    {
        return $this->repository->paginer($perPage, $filtres);
    }

    public function trouverParId(int $id): ?Adherent
    {
        return $this->repository->find($id);
    }

    public function trouverParNumCarte(string $numCarte): ?Adherent
    {
        return $this->repository->findByNumCarte($numCarte);
    }

    public function creer(AdherentDTO $dto, ?UploadedFile $photo = null): Adherent
    {
        return DB::transaction(function () use ($dto, $photo) {
            $data = $dto->toArray();

            if (empty($data['date_inscription'])) {
                $data['date_inscription'] = now()->toDateString();
            }

            if ($photo) {
                $data['photo'] = $photo->store('adherents/photos', 'public');
            }

            $password = null;

            if (!empty($data['email'])) {
                $password = Str::password(12, true, true, true, false);
                $user = User::create([
                    'name' => trim($data['prenom'] . ' ' . $data['nom']),
                    'email' => $data['email'],
                    'password' => Hash::make($password),
                    'must_change_password' => true,
                ]);
                $user->assignRole('adherent');
                $data['user_id'] = $user->id;
            }

            $adherent = $this->repository->create($data);

            if (!empty($data['email']) && $password) {
                Mail::to($data['email'])->send(new CompteAdherentCree($adherent, $password));
            }

            // Déclencher l'événement d'inscription
            event(new AdherentInscrit($adherent));

            return $adherent->fresh(['typeAdherent']);
        });
    }

    public function modifier(Adherent $adherent, AdherentDTO $dto, ?UploadedFile $photo = null): Adherent
    {
        return DB::transaction(function () use ($adherent, $dto, $photo) {
            $data = $dto->toArray();

            if ($photo) {
                // Supprimer l'ancienne photo si elle existe
                if ($adherent->photo) {
                    Storage::disk('public')->delete($adherent->photo);
                }
                $data['photo'] = $photo->store('adherents/photos', 'public');
            }

            $this->repository->update($adherent, $data);

            return $adherent->fresh(['typeAdherent']);
        });
    }

    public function supprimer(Adherent $adherent): bool
    {
        return $this->repository->delete($adherent);
    }

    public function suspendre(Adherent $adherent): Adherent
    {
        $this->repository->update($adherent, [
            'statut' => StatutAdherent::SUSPENDU->value,
        ]);

        return $adherent->fresh();
    }

    public function reactiver(Adherent $adherent): Adherent
    {
        $this->repository->update($adherent, [
            'statut' => StatutAdherent::ACTIF->value,
        ]);

        return $adherent->fresh();
    }

    public function radier(Adherent $adherent, string $motif): Adherent
    {
        $this->repository->update($adherent, [
            'statut' => StatutAdherent::RADIE->value,
            'motif_radiation' => $motif,
        ]);

        return $adherent->fresh();
    }

    public function peutEmprunter(int $adherentId): bool
    {
        return $this->repository->canBorrow($adherentId);
    }

    /**
     * Vérifie les adhésions expirées et met à jour leur statut.
     * Retourne le nombre d'adhésions expirées.
     */
    public function verifierExpirations(): int
    {
        $expires = $this->repository->findExpired();
        $count = 0;

        foreach ($expires as $adherent) {
            if ($adherent->statut === StatutAdherent::ACTIF) {
                $this->repository->update($adherent, [
                    'statut' => StatutAdherent::EXPIRE->value,
                ]);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Retourne les adhérents dont l'adhésion expire dans X jours.
     */
    public function expirantDans(int $jours): Collection
    {
        return Adherent::where('statut', StatutAdherent::ACTIF->value)
            ->whereDate('date_expiration', now()->addDays($jours)->toDateString())
            ->with('typeAdherent')
            ->get();
    }
}
