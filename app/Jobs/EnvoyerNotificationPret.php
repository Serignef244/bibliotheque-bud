<?php

namespace App\Jobs;

use App\Models\Adherent;
use App\Models\Pret;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class EnvoyerNotificationPret implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Pret $pret,
        public readonly Adherent $adherent,
    ) {}

    public function handle(): void
    {
        // Mail::to($this->adherent->email)->send(new PretConfirmationMail($this->pret));
        // Pour l'instant, on log l'action
        \Log::info("Confirmation de prêt envoyée à {$this->adherent->email} pour le prêt #{$this->pret->id}");
    }
}
