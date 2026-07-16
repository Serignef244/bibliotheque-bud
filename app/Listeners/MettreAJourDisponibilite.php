<?php

namespace App\Listeners;

use App\Events\PretEffectue;
use App\Models\Exemplaire;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MettreAJourDisponibilite implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PretEffectue $event): void
    {
        $exemplaire = Exemplaire::find($event->exemplaire->id);
        if ($exemplaire) {
            $exemplaire->update([
                'statut' => 'emprunte',
                'date_emprunt' => now(),
            ]);
        }
    }
}
