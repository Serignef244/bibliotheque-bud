<?php

use App\Models\TypeAdherent;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->user->assignRole('admin');
});

test('un admin peut voir la liste des types d\'adhérents', function () {
    TypeAdherent::factory()->count(3)->create();

    actingAs($this->user)
        ->get(route('admin.types-adherents.index'))
        ->assertStatus(200);
});

test('un admin peut créer un type d\'adhérent', function () {
    $data = [
        'nom' => 'Étudiant',
        'slug' => 'etudiant',
        'duree_jours' => 365,
        'max_books' => 5,
        'tarif_penalite' => 100,
        'description' => 'Type pour les étudiants',
    ];

    actingAs($this->user)
        ->post(route('admin.types-adherents.store'), $data)
        ->assertRedirect(route('admin.types-adherents.index'));

    assertDatabaseHas('type_adherents', [
        'nom' => 'Étudiant',
        'slug' => 'etudiant',
    ]);
});

test('un admin peut modifier un type d\'adhérent', function () {
    $type = TypeAdherent::factory()->create();

    $data = [
        'nom' => 'Étudiant Premium',
        'slug' => 'etudiant-premium',
        'duree_jours' => 365,
        'max_books' => 10,
        'tarif_penalite' => 150,
        'description' => 'Type premium pour les étudiants',
    ];

    actingAs($this->user)
        ->put(route('admin.types-adherents.update', $type), $data)
        ->assertRedirect(route('admin.types-adherents.index'));

    expect($type->fresh()->nom)->toBe('Étudiant Premium');
});

test('un admin peut supprimer un type d\'adhérent', function () {
    $type = TypeAdherent::factory()->create();

    actingAs($this->user)
        ->delete(route('admin.types-adherents.destroy', $type))
        ->assertRedirect(route('admin.types-adherents.index'));

    expect(TypeAdherent::find($type->id))->toBeNull();
});

test('le slug est généré automatiquement si non fourni', function () {
    $data = [
        'nom' => 'Enseignant',
        'duree_jours' => 365,
        'max_books' => 10,
        'tarif_penalite' => 200,
    ];

    actingAs($this->user)
        ->post(route('admin.types-adherents.store'), $data);

    $type = TypeAdherent::where('nom', 'Enseignant')->first();
    expect($type->slug)->toBe('enseignant');
});
