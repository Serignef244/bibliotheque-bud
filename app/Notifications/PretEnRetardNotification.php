<?php

namespace App\Notifications;

use App\Models\Pret;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PretEnRetardNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Pret $pret,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'error',
            'titre' => 'Retard et pénalité',
            'message' => "Le prêt du livre '{$this->pret->exemplaire->ouvrage->titre}' est en retard depuis le {$this->pret->date_retour_prevue->format('d/m/Y')}. Une pénalité financière vous a été appliquée.",
            'action_url' => route('adherent.penalites.index'),
        ];
    }
}
