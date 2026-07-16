<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\AdherentInscrit::class => [
            \App\Listeners\EnvoyerCarteAdherent::class,
            \App\Listeners\CreerCompteUtilisateur::class,
        ],
        \App\Events\PretEffectue::class => [
            \App\Listeners\EnvoyerConfirmationPret::class,
            \App\Listeners\MettreAJourDisponibilite::class,
            \App\Listeners\JournaliserAction::class,
        ],
        \App\Events\LivreRetourne::class => [
            \App\Listeners\MettreAJourDisponibiliteRetour::class,
            \App\Listeners\CalculerPenaliteAutomatique::class,
            \App\Listeners\JournaliserAction::class,
        ],
        \App\Events\PretProlonge::class => [
            \App\Listeners\JournaliserAction::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
