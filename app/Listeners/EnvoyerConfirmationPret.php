<?php

namespace App\Listeners;

use App\Events\PretEffectue;
use App\Jobs\EnvoyerNotificationPret;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnvoyerConfirmationPret implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PretEffectue $event): void
    {
        EnvoyerNotificationPret::dispatch($event->pret, $event->adherent);
    }
}
