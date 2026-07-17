<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompteUtilisateurCree extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $password,
        public string $biblioNom
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Création de votre compte personnel sur ' . $this->biblioNom,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.utilisateurs.cree',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
