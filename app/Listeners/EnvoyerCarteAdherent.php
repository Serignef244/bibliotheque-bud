<?php

namespace App\Listeners;

use App\Events\AdherentInscrit;
use App\Jobs\GenererCartePDF;
use Illuminate\Support\Facades\Bus;

class EnvoyerCarteAdherent
{
    public function handle(AdherentInscrit $event): void
    {
        // Générer la carte PDF en arrière-plan
        Bus::dispatch(new GenererCartePDF($event->adherent));
    }
}
