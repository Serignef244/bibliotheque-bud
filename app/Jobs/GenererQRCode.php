<?php

namespace App\Jobs;

use App\Models\Adherent;
use App\Services\QRCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenererQRCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Adherent $adherent,
    ) {}

    public function handle(QRCodeService $qrCodeService): void
    {
        try {
            $qrPath = $qrCodeService->generateFromNumCarte($this->adherent->num_carte);
            
            Log::info('QR Code généré avec succès', [
                'adherent_id' => $this->adherent->id,
                'num_carte' => $this->adherent->num_carte,
                'qr_path' => $qrPath,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la génération du QR Code', [
                'adherent_id' => $this->adherent->id,
                'error' => $e->getMessage(),
            ]);
            
            $this->fail($e);
        }
    }
}
