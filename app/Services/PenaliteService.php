<?php

namespace App\Services;

use App\Models\Paiement;
use App\Models\Penalite;
use App\Models\Pret;
use App\Enums\StatutPenalite;

class PenaliteService
{
    /**
     * Calculer une pénalité pour un prêt
     */
    public function calculerPenalite(Pret $pret): int
    {
        if (!$pret->estEnRetard()) {
            return 0;
        }

        $joursRetard = now()->diffInDays($pret->date_retour_prevue);
        
        $tarif = $pret->adherent->typeAdherent->tarif_penalite ?? 100;
        
        return $joursRetard * $tarif;
    }

    /**
     * Créer une pénalité à partir d'un prêt
     */
    public function creerPenalite(Pret $pret): ?Penalite
    {
        $montant = $this->calculerPenalite($pret);

        if ($montant <= 0) {
            return null;
        }

        $joursRetard = now()->diffInDays($pret->date_retour_prevue);

        return Penalite::create([
            'pret_id' => $pret->id,
            'adherent_id' => $pret->adherent_id,
            'montant' => $montant,
            'montant_restant' => $montant,
            'jours_retard' => $joursRetard,
            'statut' => StatutPenalite::IMPAYE,
        ]);
    }

    /**
     * Enregistrer un paiement sur une pénalité
     */
    public function enregistrerPaiement(Penalite $penalite, int $montant): Penalite
    {
        $nouveauRestant = max(0, $penalite->montant_restant - $montant);
        
        $penalite->update([
            'montant_restant' => $nouveauRestant,
            'statut' => $nouveauRestant == 0 ? StatutPenalite::PAYE : StatutPenalite::PARTIEL,
            'date_paiement' => now(),
        ]);

        // Créer un historique de paiement
        Paiement::create([
            'penalite_id' => $penalite->id,
            'adherent_id' => $penalite->adherent_id,
            'montant' => $montant,
            'date_paiement' => now(),
        ]);

        return $penalite;
    }

    /**
     * Vérifier si un adhérent est bloqué
     */
    public function estBloque(int $adherentId): bool
    {
        $totalImpaye = Penalite::where('adherent_id', $adherentId)
            ->where('statut', StatutPenalite::IMPAYE->value)
            ->sum('montant_restant');
        
        $seuil = config('bibliotheque.seuil_blocage', 1000);
        
        return $totalImpaye >= $seuil;
    }

    public function getTotalImpaye(int $adherentId): int
    {
        return Penalite::where('adherent_id', $adherentId)
            ->where('statut', StatutPenalite::IMPAYE->value)
            ->sum('montant_restant');
    }

    /**
     * Récupérer les pénalités d'un adhérent
     */
    public function getPenalitesByAdherent(int $adherentId)
    {
        return Penalite::where('adherent_id', $adherentId)
            ->with('pret.exemplaire.ouvrage')
            ->latest()
            ->get();
    }
}
