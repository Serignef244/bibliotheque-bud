<?php

namespace App\Jobs;

use App\Models\Adherent;
use App\Services\CarteAdherentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnvoyerCarteAdherent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Adherent $adherent,
    ) {}

    public function handle(CarteAdherentService $carteService): void
    {
        try {
            $carteService->sendByEmail($this->adherent);
            
            Log::info('Carte adhérent envoyée par email avec succès', [
                'adherent_id' => $this->adherent->id,
                'email' => $this->adherent->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de la carte adhérent par email', [
                'adherent_id' => $this->adherent->id,
                'email' => $this->adherent->email,
                'error' => $e->getMessage(),
            ]);
            
            $this->fail($e);
        }
    }
}
