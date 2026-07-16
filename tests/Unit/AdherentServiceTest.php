<?php

use App\DTO\AdherentDTO;
use App\Models\Adherent;
use App\Models\TypeAdherent;
use App\Services\AdherentService;
use Illuminate\Support\Facades\Storage;
use function Pest\Faker\fake;

beforeEach(function () {
    Storage::fake('public');
    $this->service = app(AdherentService::class);
    $this->type = TypeAdherent::factory()->create(['duree_jours' => 30]);
});

test('créer un adhérent avec succès', function () {
    $dto = new AdherentDTO(
        type_adherent_id: $this->type->id,
        nom: 'Doe',
        prenom: 'John',
        email: 'john@example.com',
        telephone: '771234567',
        adresse: '123 Rue Test',
        date_naissance: '1990-01-01',
    );

    $adherent = $this->service->creer($dto);

    expect($adherent)
        ->toBeInstanceOf(Adherent::class)
        ->and($adherent->nom)->toBe('Doe')
        ->and($adherent->prenom)->toBe('John')
        ->and($adherent->email)->toBe('john@example.com')
        ->and($adherent->num_carte)->not->toBeNull()
        ->and($adherent->date_expiration)->not->toBeNull();
});

test('modifier un adhérent avec succès', function () {
    $adherent = Adherent::factory()->create();

    $dto = new AdherentDTO(
        type_adherent_id: $this->type->id,
        nom: 'Updated',
        prenom: 'Name',
        email: 'updated@example.com',
    );

    $updated = $this->service->modifier($adherent, $dto);

    expect($updated->nom)->toBe('Updated')
        ->and($updated->email)->toBe('updated@example.com');
});

test('supprimer un adhérent avec succès', function () {
    $adherent = Adherent::factory()->create();

    $result = $this->service->supprimer($adherent);

    expect($result)->toBeTrue()
        ->and(Adherent::find($adherent->id))->toBeNull();
});

test('suspendre un adhérent', function () {
    $adherent = Adherent::factory()->create(['statut' => 'actif']);

    $suspended = $this->service->suspendre($adherent);

    expect($suspended->statut)->toBe('suspendu');
});

test('réactiver un adhérent', function () {
    $adherent = Adherent::factory()->create(['statut' => 'suspendu']);

    $reactivated = $this->service->reactiver($adherent);

    expect($reactivated->statut)->toBe('actif');
});

test('radier un adhérent', function () {
    $adherent = Adherent::factory()->create();

    $radiated = $this->service->radier($adherent, 'Test radiation');

    expect($radiated->statut)->toBe('radie')
        ->and($radiated->motif_radiation)->toBe('Test radiation');
});

test('vérifier si un adhérent peut emprunter', function () {
    $adherent = Adherent::factory()->create([
        'statut' => 'actif',
        'date_expiration' => now()->addDays(30),
    ]);

    $canBorrow = $this->service->peutEmprunter($adherent->id);

    expect($canBorrow)->toBeTrue();
});

test('un adhérent suspendu ne peut pas emprunter', function () {
    $adherent = Adherent::factory()->create([
        'statut' => 'suspendu',
        'date_expiration' => now()->addDays(30),
    ]);

    $canBorrow = $this->service->peutEmprunter($adherent->id);

    expect($canBorrow)->toBeFalse();
});

test('un adhérent expiré ne peut pas emprunter', function () {
    $adherent = Adherent::factory()->create([
        'statut' => 'actif',
        'date_expiration' => now()->subDays(1),
    ]);

    $canBorrow = $this->service->peutEmprunter($adherent->id);

    expect($canBorrow)->toBeFalse();
});

test('vérifier les adhésions expirées', function () {
    Adherent::factory()->create([
        'statut' => 'actif',
        'date_expiration' => now()->subDays(1),
    ]);

    Adherent::factory()->create([
        'statut' => 'actif',
        'date_expiration' => now()->addDays(30),
    ]);

    $count = $this->service->verifierExpirations();

    expect($count)->toBe(1);
});

test('trouver les adhérents expirant dans X jours', function () {
    Adherent::factory()->create([
        'statut' => 'actif',
        'date_expiration' => now()->addDays(7),
    ]);

    Adherent::factory()->create([
        'statut' => 'actif',
        'date_expiration' => now()->addDays(30),
    ]);

    $adherents = $this->service->expirantDans(7);

    expect($adherents->count())->toBe(1);
});

test('paginer les adhérents avec filtres', function () {
    Adherent::factory()->count(5)->create(['nom' => 'Test']);
    Adherent::factory()->count(3)->create(['nom' => 'Other']);

    $result = $this->service->paginer(10, ['recherche' => 'Test']);

    expect($result->total())->toBe(5);
});
