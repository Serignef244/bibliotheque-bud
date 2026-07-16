<?php

namespace App\Console\Commands;

use App\Jobs\EnvoyerRetardNotification;
use App\Models\Pret;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('prets:verifier-retards')]
#[Description('Vérifie les prêts en retard et met à jour leur statut')]
class VerifierRetards extends Command
{
    public function handle()
    {
        $this->info('Vérification des prêts en retard...');

        $pretsEnRetard = Pret::where('statut', 'en_cours')
            ->where('date_retour_prevue', '<', now())
            ->get();

        $count = 0;
        foreach ($pretsEnRetard as $pret) {
            $pret->update(['statut' => 'retard']);
            EnvoyerRetardNotification::dispatch($pret);
            $count++;
        }

        $this->info("{$count} prêts marqués en retard et notifications envoyées.");
        return Command::SUCCESS;
    }
}
