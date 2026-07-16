<?php

namespace App\DTO;

use Carbon\Carbon;

class RetourDTO
{
    public function __construct(
        public int $pret_id,
        public Carbon $date_retour,
        public bool $est_en_retard,
        public int $jours_retard,
        public int $penalite_montant,
        public string $message,
    ) {}

    public static function create(int $pretId, Carbon $dateRetour, int $joursRetard, int $penaliteMontant): self
    {
        return new self(
            pret_id: $pretId,
            date_retour: $dateRetour,
            est_en_retard: $joursRetard > 0,
            jours_retard: $joursRetard,
            penalite_montant: $penaliteMontant,
            message: $joursRetard > 0 
                ? "Retour en retard de {$joursRetard} jour(s). Pénalité: {$penaliteMontant} FCFA."
                : "Retour effectué à temps.",
        );
    }

    public function toArray(): array
    {
        return [
            'pret_id' => $this->pret_id,
            'date_retour' => $this->date_retour->toDateTimeString(),
            'est_en_retard' => $this->est_en_retard,
            'jours_retard' => $this->jours_retard,
            'penalite_montant' => $this->penalite_montant,
            'message' => $this->message,
        ];
    }
}
