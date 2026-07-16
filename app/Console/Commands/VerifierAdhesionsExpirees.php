<?php

namespace App\Console\Commands;

use App\Services\AdherentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerifierAdhesionsExpirees extends Command
{
    protected $signature = 'adherents:verifier-expirations';
    
    protected $description = 'Vérifie les adhésions expirées et met à jour leur statut';

    public function __construct(
        private readonly AdherentService $adherentService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('Vérification des adhésions expirées...');
        
        try {
            $count = $this->adherentService->verifierExpirations();
            
            $this->info("{$count} adhésions expirées ont été mises à jour.");
            
            Log::info('Vérification des adhésions expirées terminée', [
                'count' => $count,
            ]);
            
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Erreur lors de la vérification des adhésions expirées: ' . $e->getMessage());
            
            Log::error('Erreur lors de la vérification des adhésions expirées', [
                'error' => $e->getMessage(),
            ]);
            
            return self::FAILURE;
        }
    }
}
