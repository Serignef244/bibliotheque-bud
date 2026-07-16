<?php

use App\Models\Adherent;
use App\Models\TypeAdherent;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Storage::fake('public');
    $this->user = User::factory()->create();
    $this->user->assignRole('admin');
    $this->type = TypeAdherent::factory()->create();
});

test('un admin peut voir la liste des adhérents', function () {
    Adherent::factory()->count(3)->create();

    actingAs($this->user)
        ->get(route('admin.adherents.index'))
        ->assertStatus(200);
});

test('un admin peut créer un adhérent', function () {
    $data = [
        'type_adherent_id' => $this->type->id,
        'nom' => 'Doe',
        'prenom' => 'John',
        'email' => 'john@example.com',
        'telephone' => '771234567',
        'adresse' => '123 Rue Test',
        'date_naissance' => '1990-01-01',
    ];

    actingAs($this->user)
        ->post(route('admin.adherents.store'), $data)
        ->assertRedirect(route('admin.adherents.index'));

    assertDatabaseHas('adherents', [
        'email' => 'john@example.com',
        'nom' => 'Doe',
        'prenom' => 'John',
    ]);
});

test('un admin peut voir les détails d\'un adhérent', function () {
    $adherent = Adherent::factory()->create();

    actingAs($this->user)
        ->get(route('admin.adherents.show', $adherent))
        ->assertStatus(200)
        ->assertSee($adherent->nom)
        ->assertSee($adherent->prenom);
});

test('un admin peut modifier un adhérent', function () {
    $adherent = Adherent::factory()->create();

    $data = [
        'type_adherent_id' => $this->type->id,
        'nom' => 'Updated',
        'prenom' => 'Name',
        'email' => 'updated@example.com',
    ];

    actingAs($this->user)
        ->put(route('admin.adherents.update', $adherent), $data)
        ->assertRedirect(route('admin.adherents.show', $adherent));

    expect($adherent->fresh()->nom)->toBe('Updated');
});

test('un admin peut supprimer un adhérent', function () {
    $adherent = Adherent::factory()->create();

    actingAs($this->user)
        ->delete(route('admin.adherents.destroy', $adherent))
        ->assertRedirect(route('admin.adherents.index'));

    expect(Adherent::withTrashed()->find($adherent->id)->trashed())->toBeTrue();
});

test('un admin peut suspendre un adhérent', function () {
    $adherent = Adherent::factory()->create(['statut' => 'actif']);

    actingAs($this->user)
        ->put(route('admin.adherents.suspendre', $adherent))
        ->assertRedirect();

    expect($adherent->fresh()->statut)->toBe('suspendu');
});

test('un admin peut réactiver un adhérent', function () {
    $adherent = Adherent::factory()->create(['statut' => 'suspendu']);

    actingAs($this->user)
        ->put(route('admin.adherents.reactiver', $adherent))
        ->assertRedirect();

    expect($adherent->fresh()->statut)->toBe('actif');
});

test('un admin peut générer la carte PDF d\'un adhérent', function () {
    $adherent = Adherent::factory()->create();

    actingAs($this->user)
        ->get(route('admin.adherents.carte', $adherent))
        ->assertStatus(200)
        ->assertHeader('content-type', 'application/pdf');
});

test('la création d\'un adhérent génère automatiquement un numéro de carte', function () {
    $data = [
        'type_adherent_id' => $this->type->id,
        'nom' => 'Doe',
        'prenom' => 'John',
        'email' => 'john@example.com',
    ];

    actingAs($this->user)
        ->post(route('admin.adherents.store'), $data);

    $adherent = Adherent::where('email', 'john@example.com')->first();
    expect($adherent->num_carte)->not->toBeNull()
        ->and($adherent->num_carte)->toMatch('/^ADH-\d{4}-\d{5}$/');
});

test('la création d\'un adhérent calcule automatiquement la date d\'expiration', function () {
    $type = TypeAdherent::factory()->create(['duree_jours' => 30]);
    $data = [
        'type_adherent_id' => $type->id,
        'nom' => 'Doe',
        'prenom' => 'John',
        'email' => 'john@example.com',
    ];

    actingAs($this->user)
        ->post(route('admin.adherents.store'), $data);

    $adherent = Adherent::where('email', 'john@example.com')->first();
    $expectedDate = now()->addDays(30)->toDateString();
    expect($adherent->date_expiration->toDateString())->toBe($expectedDate);
});
