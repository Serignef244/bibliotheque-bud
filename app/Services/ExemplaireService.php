<?php

namespace App\Services;

use App\DTO\ExemplaireDTO;
use App\Enums\StatutExemplaire;
use App\Models\Exemplaire;
use App\Models\Ouvrage;
use App\Repositories\Contracts\ExemplaireRepositoryInterface;

class ExemplaireService
{
    public function __construct(
        private readonly ExemplaireRepositoryInterface $exemplaireRepo,
        private readonly CodeBarreService              $codeBarreService,
    ) {}

    public function creer(Ouvrage $ouvrage, ExemplaireDTO $dto): Exemplaire
    {
        $donnees = $dto->toArray();

        // Générer le code-barres si non fourni
        if (empty($donnees['code_barre'])) {
            $donnees['code_barre'] = $this->exemplaireRepo->genererCodeBarre($ouvrage->id);
        }

        return $this->exemplaireRepo->creer($donnees);
    }

    public function modifier(Exemplaire $exemplaire, ExemplaireDTO $dto): Exemplaire
    {
        return $this->exemplaireRepo->modifier($exemplaire, $dto->toArray());
    }

    public function supprimer(Exemplaire $exemplaire): void
    {
        if ($exemplaire->statut === StatutExemplaire::EMPRUNTE) {
            throw new \RuntimeException('Impossible de supprimer un exemplaire actuellement emprunté.');
        }
        $this->exemplaireRepo->supprimer($exemplaire);
    }

    public function changerStatut(Exemplaire $exemplaire, StatutExemplaire $statut): Exemplaire
    {
        return $this->exemplaireRepo->changerStatut($exemplaire, $statut);
    }

    public function trouverParCodeBarre(string $codeBarre): ?Exemplaire
    {
        return $this->exemplaireRepo->trouverParCodeBarre($codeBarre);
    }

    public function genererImageCodeBarre(string $codeBarre): string
    {
        return $this->codeBarreService->genererSvg($codeBarre);
    }
}
