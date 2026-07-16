<?php

namespace App\DTO;

use Carbon\Carbon;

class ProlongationDTO
{
    public function __construct(
        public int $pret_id,
        public Carbon $nouvelle_date_retour,
        public bool $prolonge,
        public string $message,
    ) {}

    public static function create(int $pretId, Carbon $nouvelleDateRetour): self
    {
        return new self(
            pret_id: $pretId,
            nouvelle_date_retour: $nouvelleDateRetour,
            prolonge: true,
            message: "Prêt prolongé jusqu'au {$nouvelleDateRetour->format('d/m/Y')}.",
        );
    }

    public static function refuse(int $pretId, string $raison): self
    {
        return new self(
            pret_id: $pretId,
            nouvelle_date_retour: now(),
            prolonge: false,
            message: "Prolongation refusée: {$raison}",
        );
    }

    public function toArray(): array
    {
        return [
            'pret_id' => $this->pret_id,
            'nouvelle_date_retour' => $this->nouvelle_date_retour->toDateString(),
            'prolonge' => $this->prolonge,
            'message' => $this->message,
        ];
    }
}
