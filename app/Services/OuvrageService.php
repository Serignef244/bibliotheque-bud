<?php

namespace App\Services;

use App\DTO\OuvrageDTO;
use App\Models\Ouvrage;
use App\Repositories\Contracts\OuvrageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class OuvrageService
{
    public function __construct(
        private readonly OuvrageRepositoryInterface $ouvrageRepo,
        private readonly UploadService              $uploadService,
    ) {}

    public function paginer(int $perPage = 15, array $filtres = []): LengthAwarePaginator
    {
        return $this->ouvrageRepo->paginer($perPage, $filtres);
    }

    public function trouverParId(int $id): ?Ouvrage
    {
        return $this->ouvrageRepo->trouverParId($id);
    }

    public function rechercherParTerme(string $terme): Collection
    {
        return $this->ouvrageRepo->rechercherParTerme($terme);
    }

    public function creer(OuvrageDTO $dto, ?UploadedFile $fichierImage = null): Ouvrage
    {
        return DB::transaction(function () use ($dto, $fichierImage) {
            $donnees = $dto->toArray();

            if ($fichierImage) {
                $donnees['image_couverture'] = $this->uploadService->uploadCouverture($fichierImage);
            }

            $ouvrage = $this->ouvrageRepo->creer($donnees);

            if (! empty($dto->categories)) {
                $this->ouvrageRepo->synchroniserCategories(
                    $ouvrage,
                    array_map('intval', $dto->categories),
                    $dto->categoriePrincipaleId,
                );
            }

            return $ouvrage->load(['categories', 'exemplaires']);
        });
    }

    public function modifier(Ouvrage $ouvrage, OuvrageDTO $dto, ?UploadedFile $fichierImage = null): Ouvrage
    {
        return DB::transaction(function () use ($ouvrage, $dto, $fichierImage) {
            $donnees = $dto->toArray();

            if ($fichierImage) {
                // Supprimer l'ancienne image
                if ($ouvrage->image_couverture) {
                    $this->uploadService->supprimer($ouvrage->image_couverture);
                }
                $donnees['image_couverture'] = $this->uploadService->uploadCouverture($fichierImage);
            }

            $ouvrage = $this->ouvrageRepo->modifier($ouvrage, $donnees);

            $this->ouvrageRepo->synchroniserCategories(
                $ouvrage,
                array_map('intval', $dto->categories),
                $dto->categoriePrincipaleId,
            );

            return $ouvrage->load(['categories', 'exemplaires']);
        });
    }

    public function supprimer(Ouvrage $ouvrage): void
    {
        if ($ouvrage->exemplaires()->whereHas('prêts', fn ($q) => $q->whereNull('date_retour_reelle'))->exists()) {
            throw new \RuntimeException('Impossible de supprimer un ouvrage ayant des prêts en cours.');
        }

        DB::transaction(function () use ($ouvrage) {
            if ($ouvrage->image_couverture) {
                $this->uploadService->supprimer($ouvrage->image_couverture);
            }
            $this->ouvrageRepo->supprimer($ouvrage);
        });
    }
}
