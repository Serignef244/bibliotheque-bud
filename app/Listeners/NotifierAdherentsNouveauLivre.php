<?php

namespace App\Listeners;

use App\Events\OuvrageAjoute;
use App\Models\Adherent;
use App\Notifications\NouveauLivreNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifierAdherentsNouveauLivre implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OuvrageAjoute $event): void
    {
        // Récupérer uniquement les adhérents actifs ayant un compte utilisateur
        $adherentsActifs = Adherent::with('user')
            ->where('statut', 'actif')
            ->whereNotNull('user_id')
            ->get();

        $count = 0;
        foreach ($adherentsActifs as $adherent) {
            if ($adherent->user) {
                $adherent->user->notify(new NouveauLivreNotification($event->ouvrage));
                $count++;
            }
        }

        Log::info("Notification 'Nouveau Livre' envoyée à {$count} adhérents actifs pour l'ouvrage #{$event->ouvrage->id}");
    }
}
