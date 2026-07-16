<?php

namespace App\Services;

use App\Enums\StatutAdherent;
use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Repositories\Interfaces\PretRepositoryInterface;

class VerificationService
{
    public function __construct(
        private readonly PretRepositoryInterface $pretRepository,
        private readonly PenaliteService $penaliteService,
    ) {}

    public function canAdherentBorrow(int $adherentId): bool
    {
        return empty($this->getVerificationErrors($adherentId));
    }

    public function isExemplaireDisponible(int $exemplaireId): bool
    {
        $activeLoan = $this->pretRepository->findActiveByExemplaire($exemplaireId);
        return $activeLoan === null;
    }

    public function getAdherentQuota(int $adherentId): int
    {
        $adherent = Adherent::with('typeAdherent')->find($adherentId);
        return $adherent->typeAdherent->max_books ?? 0;
    }

    public function getAdherentCurrentLoans(int $adherentId): int
    {
        return $this->pretRepository->countCurrentByAdherent($adherentId);
    }

    public function hasUnpaidPenalties(int $adherentId): bool
    {
        return $this->penaliteService->estBloque($adherentId);
    }

    public function getVerificationErrors(int $adherentId): array
    {
        $errors = [];

        $adherent = Adherent::with('typeAdherent')->find($adherentId);
        if (!$adherent) {
            $errors[] = 'Adhérent non trouvé';
            return $errors;
        }

        $statutAdherent = $adherent->statut;
        $estActif = $statutAdherent instanceof StatutAdherent
            ? $statutAdherent === StatutAdherent::ACTIF
            : $statutAdherent === StatutAdherent::ACTIF->value;

        if (! $estActif) {
            $errors[] = 'L\'adhérent n\'est pas actif';
        }

        if ($adherent->date_expiration && $adherent->date_expiration->isPast()) {
            $errors[] = 'L\'adhésion de l\'adhérent est expirée';
        }

        $currentLoans = $this->getAdherentCurrentLoans($adherentId);
        $maxBooks = $this->getAdherentQuota($adherentId);

        if ($currentLoans >= $maxBooks) {
            $errors[] = "Quota dépassé ({$currentLoans}/{$maxBooks})";
        }

        if ($this->hasUnpaidPenalties($adherentId)) {
            $totalImpaye = $this->penaliteService->getTotalImpaye($adherentId);
            $errors[] = "Pénalités impayées bloquantes : " . number_format($totalImpaye, 0, ',', ' ') . " FCFA";
        }

        return $errors;
    }
}
