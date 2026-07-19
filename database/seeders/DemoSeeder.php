<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;
use App\Models\Ouvrage;
use App\Models\Exemplaire;
use App\Models\TypeAdherent;
use App\Models\User;
use App\Models\Adherent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Enums\StatutExemplaire;
use App\Enums\StatutAdherent;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Catégories
        $categories = [
            'Informatique',
            'Mathématiques',
            'Physique',
            'Littérature',
            'Histoire',
            'Science-Fiction'
        ];
        
        foreach ($categories as $cat) {
            Categorie::firstOrCreate(['nom' => $cat], ['description' => "Livres sur $cat"]);
        }

        // 2. Types d'Adhérents
        $types = [
            ['nom' => 'Etudiant', 'slug' => 'etudiant', 'duree_jours' => 365, 'max_books' => 3, 'tarif_penalite' => 100, 'description' => 'Abonnement étudiant'],
            ['nom' => 'Professeur', 'slug' => 'professeur', 'duree_jours' => 365, 'max_books' => 5, 'tarif_penalite' => 100, 'description' => 'Abonnement professeur'],
            ['nom' => 'Externe', 'slug' => 'externe', 'duree_jours' => 180, 'max_books' => 2, 'tarif_penalite' => 500, 'description' => 'Abonnement externe'],
        ];

        foreach ($types as $type) {
            TypeAdherent::firstOrCreate(['nom' => $type['nom']], $type);
        }

        // 3. Ouvrages et Exemplaires
        $allCategories = Categorie::all();
        if ($allCategories->count() > 0) {
            for ($i = 1; $i <= 20; $i++) {
                $ouvrage = Ouvrage::create([
                    'titre' => "Livre Démo $i",
                    'auteurs' => "Auteur $i",
                    'isbn' => "ISBN-" . rand(1000000, 9999999),
                    'editeur' => "Editions $i",
                    'annee_publication' => rand(1990, 2024),
                    'description' => "Ceci est la description du livre $i.",
                    'langue' => 'Français'
                ]);

                // Attacher une catégorie principale
                $ouvrage->categories()->attach($allCategories->random()->id, ['principale' => true]);

                for ($j = 1; $j <= 3; $j++) {
                    Exemplaire::create([
                        'ouvrage_id' => $ouvrage->id,
                        'code_barre' => "CB-" . $ouvrage->id . "-" . $j,
                        'etat' => 5, // 5 = Neuf
                        'statut' => StatutExemplaire::DISPONIBLE,
                    ]);
                }
            }
        }

        // 4. Créer quelques Adhérents
        $adherentRole = Role::firstOrCreate(['name' => 'adherent', 'guard_name' => 'web']);
        $typesAdh = TypeAdherent::all();

        if ($typesAdh->count() > 0) {
            for ($i = 1; $i <= 5; $i++) {
                $user = User::create([
                    'name' => "Adhérent $i",
                    'email' => "adherent$i@example.com",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]);
                
                $user->assignRole($adherentRole);

                Adherent::create([
                    'user_id' => $user->id,
                    'nom' => "Nom$i",
                    'prenom' => "Prenom$i",
                    'email' => $user->email,
                    'telephone' => "77" . rand(1000000, 9999999),
                    'type_adherent_id' => $typesAdh->random()->id,
                    'statut' => StatutAdherent::ACTIF,
                    'date_inscription' => now(),
                    'date_expiration' => now()->addYear(),
                    'num_carte' => 'ADH-' . date('Y') . '-' . str_pad($i + 1000, 5, '0', STR_PAD_LEFT)
                ]);
            }
        }

        $this->command->info('Données de démonstration générées avec succès !');
    }
}
