<?php

namespace App\Listeners;

use App\Events\LivreRetourne;
use App\Events\PretEffectue;
use App\Events\PretProlonge;
use App\Repositories\Interfaces\HistoriquePretRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class JournaliserAction implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private readonly HistoriquePretRepositoryInterface $historiqueRepository,
    ) {}

    public function handle(PretEffectue|LivreRetourne|PretProlonge $event): void
    {
        $action = match ($event::class) {
            PretEffectue::class => 'creation',
            LivreRetourne::class => 'retour',
            PretProlonge::class => 'prolongation',
        };

        $this->historiqueRepository->addHistory(
            $event->pret->id,
            $action,
            auth()->id(),
            [
                'action' => $action,
                'date' => now()->toDateTimeString(),
            ]
        );
    }
}
