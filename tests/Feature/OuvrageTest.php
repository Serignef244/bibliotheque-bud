<?php

use App\Models\User;
use App\Models\Ouvrage;
use App\Models\Categorie;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'adherent']);

    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
    
    $this->adherent = User::factory()->create();
    $this->adherent->assignRole('adherent');
});

it('affiche la liste des ouvrages pour un admin', function () {
    Ouvrage::factory()->count(5)->create();
    
    $response = $this->actingAs($this->admin)
        ->get(route('admin.ouvrages.index'));
        
    $response->assertStatus(200);
});

it('permet à un admin de créer un ouvrage avec une image', function () {
    Storage::fake('public');
    
    $file = UploadedFile::fake()->image('couverture.jpg');
    $categorie = Categorie::factory()->create();
    
    $response = $this->actingAs($this->admin)
        ->post(route('admin.ouvrages.store'), [
            'titre' => 'Le Petit Prince',
            'auteurs' => 'Antoine de Saint-Exupéry',
            'langue' => 'Français',
            'categories' => [$categorie->id],
            'image' => $file
        ]);
        
    $response->assertRedirect(route('admin.ouvrages.index'));
    
    $this->assertDatabaseHas('ouvrages', [
        'titre' => 'Le Petit Prince'
    ]);
    
    $ouvrage = Ouvrage::where('titre', 'Le Petit Prince')->first();
    expect($ouvrage->image_couverture)->not->toBeNull();
    Storage::disk('public')->assertExists($ouvrage->image_couverture);
});

it('vérifie que les statistiques des exemplaires se mettent à jour', function () {
    $ouvrage = Ouvrage::factory()->create();
    expect($ouvrage->nombre_exemplaires_total)->toBe(0);
    
    // Création d'un exemplaire disponible
    $ouvrage->exemplaires()->create([
        'code_barre' => 'TEST-001',
        'statut' => \App\Enums\StatutExemplaire::DISPONIBLE,
        'etat' => 5
    ]);
    
    $ouvrage->refresh();
    expect($ouvrage->nombre_exemplaires_total)->toBe(1)
        ->and($ouvrage->nombre_exemplaires_disponibles)->toBe(1)
        ->and($ouvrage->est_disponible)->toBeTrue();
        
    // Passage en emprunté
    $ouvrage->exemplaires()->first()->update([
        'statut' => \App\Enums\StatutExemplaire::EMPRUNTE
    ]);
    
    $ouvrage->refresh();
    expect($ouvrage->nombre_exemplaires_total)->toBe(1)
        ->and($ouvrage->nombre_exemplaires_disponibles)->toBe(0)
        ->and($ouvrage->est_disponible)->toBeFalse();
});
