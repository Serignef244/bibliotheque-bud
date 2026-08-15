<?php

namespace App\Notifications;

use App\Models\Adherent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdhesionExpirantNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Adherent $adherent,
        public readonly int $joursRestants,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'warning',
            'titre' => 'Adhésion expirant bientôt',
            'message' => "Votre adhésion expire dans {$this->joursRestants} jours (le {$this->adherent->date_expiration->format('d/m/Y')}). Veuillez penser à la renouveler.",
            'action_url' => route('adherent.profil'),
        ];
    }
}
