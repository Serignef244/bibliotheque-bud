<?php

use App\Models\User;
use App\Models\Categorie;

use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'bibliothecaire']);
    Role::firstOrCreate(['name' => 'adherent']);

    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
    
    $this->bibliothecaire = User::factory()->create();
    $this->bibliothecaire->assignRole('bibliothecaire');
    
    $this->adherent = User::factory()->create();
    $this->adherent->assignRole('adherent');
});

it('permet à un admin de voir la liste des catégories', function () {
    Categorie::factory()->count(3)->create();
    
    $response = $this->actingAs($this->admin)
        ->get(route('admin.categories.index'));
        
    $response->assertStatus(200);
});

it('empêche un adhérent de voir les catégories en admin', function () {
    $response = $this->actingAs($this->adherent)
        ->get(route('admin.categories.index'));
        
    $response->assertStatus(403);
});

it('permet de créer une catégorie', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.categories.store'), [
            'nom' => 'Informatique',
            'description' => 'Livres IT',
            'ordre' => 1,
            'actif' => 1,
        ]);

    $response->assertRedirect(route('admin.categories.index'));
    $this->assertDatabaseHas('categories', [
        'nom' => 'Informatique'
    ]);
});

it('autorise la création de catégorie pour un admin via la requête', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.categories.store'), [
            'nom' => 'Science',
            'description' => 'Livres scientifiques',
            'ordre' => 2,
            'actif' => 1,
        ]);

    $response->assertSessionDoesNotHaveErrors();
    $response->assertRedirect(route('admin.categories.index'));
});

it('empêche la création de catégories cycliques', function () {
    $parent = Categorie::factory()->create(['nom' => 'Parent']);
    $enfant = Categorie::factory()->create(['nom' => 'Enfant', 'parent_id' => $parent->id]);
    
    $response = $this->actingAs($this->admin)
        ->put(route('admin.categories.update', $parent), [
            'nom' => 'Parent',
            'parent_id' => $enfant->id // Le parent devient l'enfant de son enfant = Cycle !
        ]);
        
    $response->assertSessionHasErrors('parent_id');
});
