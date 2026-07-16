<?php

namespace App\Services;

use App\Models\Pret;
use Carbon\Carbon;

class ProlongationService
{
    public function canProlonger(Pret $pret): bool
    {
        return $pret->peutEtreProlonge();
    }

    public function prolonger(Pret $pret): Pret
    {
        $nouvelleDate = $this->getNouvelleDate($pret);

        $pret->update([
            'date_retour_prevue' => $nouvelleDate,
            'prolonge' => true,
        ]);

        return $pret->fresh();
    }

    public function getNouvelleDate(Pret $pret): Carbon
    {
        return $pret->date_retour_prevue->addDays(7);
    }

    public function getRaisonsRefus(Pret $pret): array
    {
        $raisons = [];

        if ($pret->statut !== 'en_cours') {
            $raisons[] = 'Le prêt n\'est pas en cours';
        }

        if ($pret->prolonge) {
            $raisons[] = 'Le prêt a déjà été prolongé';
        }

        if ($pret->estEnRetard()) {
            $raisons[] = 'Le prêt est en retard';
        }

        return $raisons;
    }
}
