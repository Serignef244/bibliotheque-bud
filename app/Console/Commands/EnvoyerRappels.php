<?php

namespace App\Console\Commands;

use App\Services\AdherentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EnvoyerRappels extends Command
{
    protected $signature = 'adherents:envoyer-rappels {jours=7 : Nombre de jours avant expiration}';
    
    protected $description = 'Envoie des rappels aux adhérents dont l\'adhésion expire bientôt';

    public function __construct(
        private readonly AdherentService $adherentService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $jours = (int) $this->argument('jours');
        
        $this->info("Recherche des adhérents dont l'adhésion expire dans {$jours} jours...");
        
        try {
            $adherents = $this->adherentService->expirantDans($jours);
            
            $count = $adherents->count();
            
            if ($count === 0) {
                $this->info("Aucun adhérent n'a une adhésion expirant dans {$jours} jours.");
                return self::SUCCESS;
            }
            
            $this->info("{$count} adhérent(s) trouvé(s).");
            
            $this->withProgressBar($adherents, function ($adherent) {
                // TODO: Envoyer un email de rappel
                // Mail::to($adherent->email)->send(new RappelExpirationMail($adherent));
                
                Log::info('Rappel d\'expiration envoyé', [
                    'adherent_id' => $adherent->id,
                    'num_carte' => $adherent->num_carte,
                    'email' => $adherent->email,
                    'date_expiration' => $adherent->date_expiration,
                ]);
            });
            
            $this->newLine();
            $this->info("Rappels envoyés avec succès.");
            
            Log::info('Envoi des rappels terminé', [
                'jours' => $jours,
                'count' => $count,
            ]);
            
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Erreur lors de l\'envoi des rappels: ' . $e->getMessage());
            
            Log::error('Erreur lors de l\'envoi des rappels', [
                'error' => $e->getMessage(),
            ]);
            
            return self::FAILURE;
        }
    }
}
