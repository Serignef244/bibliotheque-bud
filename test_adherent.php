<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Adherent;
use App\Models\TypeAdherent;
use App\Models\Ouvrage;
use App\Models\Exemplaire;
use App\Models\Pret;
use App\Models\Penalite;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

echo "Création de l'utilisateur de test...\n";

// 1. S'assurer que le rôle adhérent existe
$role = Role::firstOrCreate(['name' => 'adherent', 'guard_name' => 'web']);

// 2. Créer l'utilisateur
$user = User::updateOrCreate(
    ['email' => 'test@adherent.com'],
    [
        'name' => 'Mamadou Diop',
        'password' => Hash::make('password'),
    ]
);
$user->assignRole($role);

// 3. Créer le type d'adhérent
$type = TypeAdherent::firstOrCreate(
    ['nom' => 'Étudiant'],
    [
        'duree_max_pret' => 14,
        'max_books' => 3,
        'tarif_penalite_jour' => 100,
        'montant_cotisation' => 5000
    ]
);

// 4. Créer l'adhérent
$adherent = Adherent::updateOrCreate(
    ['user_id' => $user->id],
    [
        'nom' => 'Diop',
        'prenom' => 'Mamadou',
        'email' => 'test@adherent.com',
        'num_carte' => 'ADH-2025-TEST',
        'type_adherent_id' => $type->id,
        'date_naissance' => '2000-01-01',
        'adresse' => 'Dakar, Sénégal',
        'telephone' => '77 123 45 67',
        'statut' => 'actif',
        'date_inscription' => now(),
        'date_expiration' => now()->addYear(),
    ]
);

// 5. Récupérer ou créer des ouvrages et exemplaires pour les prêts
$ouvrages = Ouvrage::take(5)->get();
if ($ouvrages->count() < 5) {
    echo "⚠️ Pas assez d'ouvrages dans la base. Veuillez en créer quelques-uns dans l'espace admin d'abord si vous voulez voir de vraies données.\n";
} else {
    // Nettoyer les anciens prêts de ce test
    Pret::where('adherent_id', $adherent->id)->forceDelete();
    Penalite::where('adherent_id', $adherent->id)->forceDelete();

    // 5.1 Prêt en cours normal
    $ex1 = $ouvrages[0]->exemplaires()->first();
    if($ex1) {
        $ex1->update(['statut' => 'emprunte']);
        Pret::create([
            'adherent_id' => $adherent->id,
            'exemplaire_id' => $ex1->id,
            'date_emprunt' => now()->subDays(2),
            'date_retour_prevue' => now()->addDays(12),
            'statut' => 'en_cours',
        ]);
    }

    // 5.2 Prêt en retard
    $ex2 = $ouvrages[1]->exemplaires()->first();
    if($ex2) {
        $ex2->update(['statut' => 'emprunte']);
        $pretRetard = Pret::create([
            'adherent_id' => $adherent->id,
            'exemplaire_id' => $ex2->id,
            'date_emprunt' => now()->subDays(20),
            'date_retour_prevue' => now()->subDays(6),
            'statut' => 'en_cours',
        ]);
        
        // 5.3 Créer une pénalité (facture)
        Penalite::create([
            'adherent_id' => $adherent->id,
            'pret_id' => $pretRetard->id,
            'montant' => 600, // 6 jours * 100
            'montant_restant' => 600,
            'statut' => \App\Enums\StatutPenalite::IMPAYE,
        ]);
    }

    // 5.4 Prêt historique (retourné)
    $ex3 = $ouvrages[2]->exemplaires()->first();
    if($ex3) {
        $ex3->update(['statut' => 'disponible']);
        Pret::create([
            'adherent_id' => $adherent->id,
            'exemplaire_id' => $ex3->id,
            'date_emprunt' => now()->subMonths(2),
            'date_retour_prevue' => now()->subMonths(2)->addDays(14),
            'date_retour_reelle' => now()->subMonths(2)->addDays(10),
            'statut' => 'retourne',
        ]);
    }
}

// 6. Ajouter des notifications
$user->notifications()->delete(); // clear
$user->notify(new class extends \Illuminate\Notifications\Notification {
    public function via($notifiable) { return ['database']; }
    public function toDatabase($notifiable) {
        return [
            'type' => 'success',
            'title' => 'Bienvenue !',
            'message' => 'Bienvenue dans votre nouvelle bibliothèque numérique.',
        ];
    }
});

$user->notify(new class extends \Illuminate\Notifications\Notification {
    public function via($notifiable) { return ['database']; }
    public function toDatabase($notifiable) {
        return [
            'type' => 'warning',
            'title' => 'Attention au retard',
            'message' => 'Un de vos livres a dépassé sa date de retour prévue.',
        ];
    }
});

echo "\n✅ COMPTE CRÉÉ AVEC SUCCÈS !\n";
echo "========================================\n";
echo "Lien de connexion : http://127.0.0.1:8000/login\n";
echo "Email           : test@adherent.com\n";
echo "Mot de passe    : password\n";
echo "========================================\n";
