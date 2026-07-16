<?php

namespace App\Console\Commands;

use App\Jobs\EnvoyerRappelEcheance;
use App\Models\Pret;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('prets:envoyer-rappels {jours=3}')]
#[Description('Envoie des rappels pour les prêts arrivant à échéance')]
class EnvoyerRappelsPrets extends Command
{
    public function handle()
    {
        $jours = $this->argument('jours');
        $dateEcheance = now()->addDays($jours);

        $this->info("Recherche des prêts arrivant à échéance dans {$jours} jours...");

        $pretsAEcheance = Pret::where('statut', 'en_cours')
            ->where('date_retour_prevue', $dateEcheance->toDateString())
            ->get();

        $count = 0;
        foreach ($pretsAEcheance as $pret) {
            EnvoyerRappelEcheance::dispatch($pret);
            $count++;
        }

        $this->info("{$count} rappels envoyés.");
        return Command::SUCCESS;
    }
}
