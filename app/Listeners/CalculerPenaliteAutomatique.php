<?php

namespace App\Listeners;

use App\Events\LivreRetourne;
use App\Repositories\Interfaces\HistoriquePretRepositoryInterface;
use App\Services\PenaliteService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculerPenaliteAutomatique implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private readonly HistoriquePretRepositoryInterface $historiqueRepository,
        private readonly PenaliteService $penaliteService,
    ) {}

    public function handle(LivreRetourne $event): void
    {
        if ($event->retourDTO->est_en_retard) {
            // Créer la pénalité dans la base de données
            $this->penaliteService->creerPenalite($event->pret);
            
            // Ajouter à l'historique
            if ($event->retourDTO->penalite_montant > 0) {
                $this->historiqueRepository->addHistory(
                    $event->pret->id,
                    'penalite',
                    auth()->id(),
                    [
                        'montant' => $event->retourDTO->penalite_montant,
                        'jours_retard' => $event->retourDTO->jours_retard,
                    ]
                );
            }
        }
    }
}
