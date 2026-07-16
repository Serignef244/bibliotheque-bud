<?php

namespace App\Services;

use App\DTO\RetourDTO;
use App\Models\Exemplaire;
use App\Models\Penalite;
use App\Models\Pret;
use App\Repositories\Interfaces\HistoriquePretRepositoryInterface;
use App\Repositories\Interfaces\PretRepositoryInterface;
use Carbon\Carbon;

class RetourService
{
    public function __construct(
        private readonly PretRepositoryInterface $pretRepository,
        private readonly HistoriquePretRepositoryInterface $historiqueRepository,
    ) {}

    public function enregistrerRetour(Pret $pret): RetourDTO
    {
        $joursRetard = $this->calculerJoursRetard($pret);
        $penaliteMontant = $this->calculerPenalite($pret);

        $pret->update([
            'statut' => 'rendu',
            'date_retour_reelle' => now(),
        ]);

        $this->mettreAJourExemplaire($pret);

        $this->historiqueRepository->addHistory(
            $pret->id,
            'retour',
            auth()->id(),
            [
                'date_retour' => now()->toDateTimeString(),
                'jours_retard' => $joursRetard,
                'penalite_montant' => $penaliteMontant,
            ]
        );

        // La création de la pénalité est désormais déléguée au listener CalculerPenaliteAutomatique
        // via l'événement LivreRetourne qui est dispatché dans PretService@retourner

        return RetourDTO::create($pret->id, now(), $joursRetard, $penaliteMontant);
    }

    public function calculerJoursRetard(Pret $pret): int
    {
        if (!$pret->estEnRetard()) {
            return 0;
        }
        return now()->diffInDays($pret->date_retour_prevue);
    }

    public function calculerPenalite(Pret $pret): int
    {
        $joursRetard = $this->calculerJoursRetard($pret);
        if ($joursRetard === 0) {
            return 0;
        }

        $adherent = $pret->adherent;
        $tarifParJour = $adherent->typeAdherent->tarif_penalite ?? 100;

        return $joursRetard * $tarifParJour;
    }

    public function mettreAJourExemplaire(Pret $pret): void
    {
        $exemplaire = Exemplaire::find($pret->exemplaire_id);
        if ($exemplaire) {
            $exemplaire->update([
                'statut' => 'disponible',
                'date_retour' => now(),
            ]);
        }
    }
}
