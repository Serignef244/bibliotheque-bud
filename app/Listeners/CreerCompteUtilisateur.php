<?php

namespace App\Listeners;

use App\Events\AdherentInscrit;
use Illuminate\Support\Facades\Log;

class CreerCompteUtilisateur
{
    public function handle(AdherentInscrit $event): void
    {
        // Le compte utilisateur est déjà créé dans l'AdherentObserver
        // Ce listener peut être utilisé pour d'autres actions post-création
        Log::info('Compte utilisateur créé pour l\'adhérent', [
            'adherent_id' => $event->adherent->id,
            'num_carte' => $event->adherent->num_carte,
        ]);
    }
}
