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

class GenererCartePDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Adherent $adherent,
    ) {}

    public function handle(CarteAdherentService $carteService): void
    {
        try {
            $pdfPath = $carteService->generatePDF($this->adherent);
            
            Log::info('Carte adhérent générée avec succès', [
                'adherent_id' => $this->adherent->id,
                'num_carte' => $this->adherent->num_carte,
                'pdf_path' => $pdfPath,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération de la carte adhérent', [
                'adherent_id' => $this->adherent->id,
                'error' => $e->getMessage(),
            ]);
            
            $this->fail($e);
        }
    }
}
