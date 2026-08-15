<?php

namespace App\Notifications;

use App\Models\Ouvrage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauLivreNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Ouvrage $ouvrage,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📚 Nouveau livre à la bibliothèque')
            ->greeting('Bonjour !')
            ->line('Un nouvel ouvrage vient d\'être ajouté à notre catalogue :')
            ->line('📖 ' . $this->ouvrage->titre)
            ->line('✍️ ' . $this->ouvrage->auteur)
            ->line('📅 ' . $this->ouvrage->exemplaires()->count() . ' exemplaires disponibles')
            ->action('👀 Voir le livre', route('adherent.catalogue.show', $this->ouvrage->id))
            ->line('Bonne lecture !')
            ->salutation('L\'équipe de la bibliothèque');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'success',
            'titre' => 'Nouveau livre disponible !',
            'message' => "📖 {$this->ouvrage->titre} - {$this->ouvrage->auteur}\n{$this->ouvrage->exemplaires()->count()} exemplaires disponibles",
            'action_url' => route('adherent.catalogue.show', $this->ouvrage->id),
        ];
    }
}
