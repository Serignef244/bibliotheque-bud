<?php

use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Models\HistoriquePret;
use App\Models\Ouvrage;
use App\Models\Pret;
use App\Models\TypeAdherent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un historique est créé lors de la création dun prêt', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $user = User::factory()->create();

    $pret = Pret::create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'date_emprunt' => now(),
        'date_retour_prevue' => now()->addDays(14),
        'statut' => 'en_cours',
    ]);

    $historique = HistoriquePret::create([
        'pret_id' => $pret->id,
        'action' => 'creation',
        'utilisateur_id' => $user->id,
        'details' => ['date_emprunt' => $pret->date_emprunt->toDateString()],
    ]);

    expect($historique)->toBeInstanceOf(HistoriquePret::class)
        ->and($historique->action)->toBe('creation')
        ->and($historique->pret_id)->toBe($pret->id)
        ->and($historique->utilisateur_id)->toBe($user->id);
});

test('un historique est créé lors du retour dun prêt', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $user = User::factory()->create();

    $pret = Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'statut' => 'en_cours',
    ]);

    $pret->update([
        'statut' => 'rendu',
        'date_retour_effective' => now(),
    ]);

    $historique = HistoriquePret::create([
        'pret_id' => $pret->id,
        'action' => 'retour',
        'utilisateur_id' => $user->id,
        'details' => ['date_retour' => $pret->date_retour_effective->toDateString()],
    ]);

    expect($historique->action)->toBe('retour')
        ->and($historique->pret_id)->toBe($pret->id);
});

test('un historique est créé lors de la prolongation dun prêt', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $user = User::factory()->create();

    $pret = Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'statut' => 'en_cours',
        'date_retour_prevue' => now()->addDays(14),
        'nombre_prolongations' => 0,
    ]);

    $pret->update([
        'date_retour_prevue' => $pret->date_retour_prevue->addDays(7),
        'nombre_prolongations' => 1,
    ]);

    $historique = HistoriquePret::create([
        'pret_id' => $pret->id,
        'action' => 'prolongation',
        'utilisateur_id' => $user->id,
        'details' => ['nouvelle_date' => $pret->date_retour_prevue->toDateString()],
    ]);

    expect($historique->action)->toBe('prolongation')
        ->and($historique->pret_id)->toBe($pret->id);
});

test('lhistorique dun prêt peut être récupéré', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $user = User::factory()->create();

    $pret = Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'statut' => 'en_cours',
    ]);

    HistoriquePret::factory()->count(3)->create(['pret_id' => $pret->id]);

    $historique = HistoriquePret::where('pret_id', $pret->id)->get();

    expect($historique)->toHaveCount(3)
        ->and($historique->first()->pret_id)->toBe($pret->id);
});

test('lhistorique peut être filtré par action', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $user = User::factory()->create();

    $pret = Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'statut' => 'en_cours',
    ]);

    HistoriquePret::factory()->create(['pret_id' => $pret->id, 'action' => 'creation']);
    HistoriquePret::factory()->create(['pret_id' => $pret->id, 'action' => 'retour']);
    HistoriquePret::factory()->create(['pret_id' => $pret->id, 'action' => 'prolongation']);

    $creationHistory = HistoriquePret::where('pret_id', $pret->id)->where('action', 'creation')->get();
    $retourHistory = HistoriquePret::where('pret_id', $pret->id)->where('action', 'retour')->get();

    expect($creationHistory)->toHaveCount(1)
        ->and($retourHistory)->toHaveCount(1);
});
