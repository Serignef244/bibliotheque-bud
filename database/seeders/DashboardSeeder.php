<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Models\Pret;
use App\Models\Penalite;
use App\Models\User;
use App\Enums\StatutPret;
use App\Enums\StatutPenalite;
use App\Enums\StatutExemplaire;
use Carbon\Carbon;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        // On s'assure d'avoir au moins quelques adhérents
        $adherents = Adherent::inRandomOrder()->limit(5)->get();
        if ($adherents->count() < 1) {
            $this->command->info("Aucun adhérent trouvé.");
            return;
        }

        // On s'assure d'avoir des exemplaires disponibles
        $exemplaires = Exemplaire::where('statut', StatutExemplaire::DISPONIBLE->value)->inRandomOrder()->limit(10)->get();
        if ($exemplaires->count() < 5) {
            $this->command->info("Pas assez d'exemplaires.");
            return;
        }

        // 1. Créer des prêts en cours (Normaux)
        for ($i = 0; $i < 3; $i++) {
            $exemplaire = $exemplaires->pop();
            $adherent = $adherents->random();
            $datePret = Carbon::now()->subDays(rand(1, 10));
            
            Pret::create([
                'adherent_id' => $adherent->id,
                'exemplaire_id' => $exemplaire->id,
                'date_emprunt' => $datePret,
                'date_retour_prevue' => $datePret->copy()->addDays(15),
                'statut' => StatutPret::EN_COURS->value,
                'prolonge' => rand(0, 1) == 1,
            ]);

            $exemplaire->update(['statut' => StatutExemplaire::EMPRUNTE->value]);
        }

        // 2. Créer des prêts terminés (Historique pour les graphes)
        for ($i = 0; $i < 5; $i++) {
            $exemplaire = $exemplaires->pop(); // On réutilise des exemplaires
            $adherent = $adherents->random();
            $datePret = Carbon::now()->subMonths(rand(1, 5))->subDays(rand(1, 20));
            
            Pret::create([
                'adherent_id' => $adherent->id,
                'exemplaire_id' => $exemplaire->id,
                'date_emprunt' => $datePret,
                'date_retour_prevue' => $datePret->copy()->addDays(15),
                'date_retour_reelle' => $datePret->copy()->addDays(rand(5, 14)),
                'statut' => StatutPret::RENDU->value,
            ]);
            // Ils sont retournés donc exemplaires à nouveau dispos
        }

        // 3. Créer des prêts en retard (Génère des pénalités)
        for ($i = 0; $i < 2; $i++) {
            if ($exemplaires->isEmpty()) break;
            $exemplaire = $exemplaires->pop();
            $adherent = $adherents->random();
            $datePret = Carbon::now()->subDays(rand(20, 30)); // Il y a un mois
            
            $pret = Pret::create([
                'adherent_id' => $adherent->id,
                'exemplaire_id' => $exemplaire->id,
                'date_emprunt' => $datePret,
                'date_retour_prevue' => $datePret->copy()->addDays(15), // Devait être rendu il y a 5 à 15 jours
                'statut' => StatutPret::RETARD->value,
            ]);

            $exemplaire->update(['statut' => StatutExemplaire::EMPRUNTE->value]);

            // Générer une pénalité non payée
            Penalite::create([
                'adherent_id' => $adherent->id,
                'pret_id' => $pret->id,
                'montant' => rand(5, 15) * 100, // 500 à 1500 FCFA
                'motif' => 'Retard de restitution',
                'statut' => StatutPenalite::NON_PAYEE->value,
            ]);
        }

        // 4. Une pénalité déjà payée pour les stats
        $pretPaye = Pret::where('statut', StatutPret::RENDU->value)->first();
        if ($pretPaye) {
            Penalite::create([
                'adherent_id' => $pretPaye->adherent_id,
                'pret_id' => $pretPaye->id,
                'montant' => 1000,
                'motif' => 'Retard de restitution',
                'statut' => StatutPenalite::PAYEE->value,
            ]);
        }

        $this->command->info('✅ Données de tableau de bord générées avec succès !');
    }
}
