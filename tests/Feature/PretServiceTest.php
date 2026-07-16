<?php

use App\DTO\PretDTO;
use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Models\Ouvrage;
use App\Models\Pret;
use App\Models\TypeAdherent;
use App\Services\PretService;
use App\Services\VerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

test('le service peut créer un prêt', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);

    Event::fake();

    $pretService = app(PretService::class);
    $dto = new PretDTO(
        adherentId: $adherent->id,
        exemplaireId: $exemplaire->id,
        dateEmprunt: now(),
        remarques: null,
    );

    $pret = $pretService->creer($dto);

    expect($pret)->toBeInstanceOf(Pret::class)
        ->and($pret->statut)->toBe('en_cours')
        ->and($pret->adherent_id)->toBe($adherent->id)
        ->and($pret->exemplaire_id)->toBe($exemplaire->id);

    $exemplaire->refresh();
    expect($exemplaire->statut)->toBe('emprunte');
});

test('le service peut retourner un prêt', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $pret = Pret::factory()->create([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'statut' => 'en_cours',
    ]);

    Event::fake();

    $pretService = app(PretService::class);
    $pretService->retourner($pret, null);

    $pret->refresh();
    expect($pret->statut)->toBe('rendu')
        ->and($pret->date_retour_effective)->not->toBeNull();

    $exemplaire->refresh();
    expect($exemplaire->statut)->toBe('disponible');
});

test('le service peut prolonger un prêt', function () {
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

    Event::fake();

    $pretService = app(PretService::class);
    $pretService->prolonger($pret, 7);

    $pret->refresh();
    expect($pret->nombre_prolongations)->toBe(1)
        ->and($pret->date_retour_prevue)->toBeGreaterThan(now()->addDays(14));
});

test('le service de vérification détecte les quotas dépassés', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 2]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire1 = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);
    $exemplaire2 = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'disponible']);

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

    $verificationService = app(VerificationService::class);
    $errors = $verificationService->getVerificationErrors($adherent->id);

    expect($errors)->toContain('Quota dépassé (2/2)');
});

test('le service de vérification reconnaît un adhérent actif', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'actif']);

    $verificationService = app(VerificationService::class);
    $errors = $verificationService->getVerificationErrors($adherent->id);

    expect($errors)->not->toContain("L'adhérent n'est pas actif");
});

test('le service de vérification détecte les adhérents inactifs', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create(['type_adherent_id' => $typeAdherent->id, 'statut' => 'inactif']);

    $verificationService = app(VerificationService::class);
    $errors = $verificationService->getVerificationErrors($adherent->id);

    expect($errors)->toContain("L'adhérent n'est pas actif");
});

test('le service de vérification détecte les adhésions expirées', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 5]);
    $adherent = Adherent::factory()->create([
        'type_adherent_id' => $typeAdherent->id,
        'statut' => 'actif',
        'date_expiration' => now()->subDays(10),
    ]);

    $verificationService = app(VerificationService::class);
    $errors = $verificationService->getVerificationErrors($adherent->id);

    expect($errors)->toContain("L'adhésion de l'adhérent est expirée");
});

test('le service de vérification détecte les exemplaires non disponibles', function () {
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create(['ouvrage_id' => $ouvrage->id, 'statut' => 'emprunte']);

    $verificationService = app(VerificationService::class);
    $isDisponible = $verificationService->isExemplaireDisponible($exemplaire->id);

    expect($isDisponible)->toBeFalse();
});
