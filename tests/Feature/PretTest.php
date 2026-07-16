<?php

use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Models\Ouvrage;
use App\Models\Pret;
use App\Models\TypeAdherent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

test('un adhérent peut emprunter un ouvrage', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);

    Event::fake();

    $pret = Pret::create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'date_emprunt' => now(),
        'date_retour_prevue' => now()->addDays(14),
        'statut' => 'en_cours',
    ]);

    expect($pret)->toBeInstanceOf(Pret::class)
        ->and($pret->statut)->toBe('en_cours')
        ->and($pret->adherent_id)->toBe($adherent->id)
        ->and($pret->exemplaire_id)->toBe($exemplaire->id);

    $exemplaire->refresh();
    expect($exemplaire->statut)->toBe('emprunte');
});

test('un prêt peut être retourné', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $pret = Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'statut' => 'en_cours',
    ]);

    $pret->update([
        'statut' => 'rendu',
        'date_retour_effective' => now(),
    ]);

    $pret->refresh();
    expect($pret->statut)->toBe('rendu')
        ->and($pret->date_retour_effective)->not->toBeNull();

    $exemplaire->refresh();
    expect($exemplaire->statut)->toBe('disponible');
});

test('un prêt peut être prolongé', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
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

    $pret->refresh();
    expect($pret->nombre_prolongations)->toBe(1)
        ->and($pret->date_retour_prevue)->toBeGreaterThan(now()->addDays(14));
});

test('un prêt en retard est détecté correctement', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $pret = Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'statut' => 'en_cours',
        'date_retour_prevue' => now()->subDays(5),
    ]);

    expect($pret->estEnRetard())->toBeTrue()
        ->and($pret->joursDeRetard())->toBeGreaterThanOrEqual(5);
});

test('un adhérent ne peut pas emprunter si quota dépassé', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 2]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire1 = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $exemplaire2 = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $exemplaire3 = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);

    Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire1->id,
        'statut' => 'en_cours',
    ]);

    Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire2->id,
        'statut' => 'en_cours',
    ]);

    $currentLoans = Pret::where('adherent_id', $adherent->id)
        ->whereIn('statut', ['en_cours', 'retard'])
        ->count();

    expect($currentLoans)->toBe(2)
        ->and($currentLoans)->toBeGreaterThanOrEqual($typeAdherent->max_books);
});

test('un exemplaire non disponible ne peut pas être emprunté', function () {
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'emprunte']);

    expect($exemplaire->statut)->toBe('emprunte');

    $activeLoan = Pret::where('exemplaire_id', $exemplaire->id)
        ->whereIn('statut', ['en_cours', 'retard'])
        ->first();

    expect($activeLoan)->not->toBeNull();
});
