<?php

namespace App\Notifications;

use App\Models\Pret;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PretEcheanceNotification extends Notification
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
            'type' => 'info',
            'titre' => 'Rappel d\'échéance de prêt',
            'message' => "Le livre '{$this->pret->exemplaire->ouvrage->titre}' doit être retourné le {$this->pret->date_retour_prevue->format('d/m/Y')}. Pensez à le ramener ou à le prolonger si possible.",
            'action_url' => route('adherent.prets.index'),
        ];
    }
}
