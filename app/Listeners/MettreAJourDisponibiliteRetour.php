<?php

namespace App\Listeners;

use App\Events\LivreRetourne;
use App\Models\Exemplaire;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MettreAJourDisponibiliteRetour implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(LivreRetourne $event): void
    {
        $exemplaire = Exemplaire::find($event->exemplaire->id);
        if ($exemplaire) {
            $exemplaire->update([
                'statut' => 'disponible',
                'date_retour' => now(),
            ]);
        }
    }
}
