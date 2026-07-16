<?php

namespace App\Jobs;

use App\Models\Pret;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class EnvoyerRetardNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Pret $pret,
    ) {}

    public function handle(): void
    {
        // Mail::to($this->pret->adherent->email)->send(new RetardNotificationMail($this->pret));
        \Log::info("Notification de retard envoyée à {$this->pret->adherent->email} pour le prêt #{$this->pret->id}");
    }
}
