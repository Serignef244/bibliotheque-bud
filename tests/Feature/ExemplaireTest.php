<?php

use App\Models\User;
use App\Models\Ouvrage;
use App\Models\Exemplaire;

use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'bibliothecaire']);
    Role::firstOrCreate(['name' => 'adherent']);

    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
    $this->ouvrage = Ouvrage::factory()->create();
});

it('permet à un admin d\'accéder à la liste des exemplaires d\'un ouvrage', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.ouvrages.exemplaires.index', $this->ouvrage));

    $response->assertOk();
});

it('génère automatiquement un code-barres lors de la création d\'un exemplaire si non fourni', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.ouvrages.exemplaires.store', $this->ouvrage), [
            'ouvrage_id' => $this->ouvrage->id,
            'etat' => 5,
        ]);
        
    $response->assertRedirect(route('admin.ouvrages.show', $this->ouvrage));
    
    $exemplaire = Exemplaire::first();
    expect($exemplaire->code_barre)->not->toBeNull()
        ->and($exemplaire->code_barre)->toStartWith('BUD-');
});

it('permet de modifier le statut d\'un exemplaire', function () {
    $exemplaire = Exemplaire::factory()->create([
        'ouvrage_id' => $this->ouvrage->id,
        'statut' => \App\Enums\StatutExemplaire::DISPONIBLE
    ]);
    
    $response = $this->actingAs($this->admin)
        ->put(route('admin.exemplaires.update', $exemplaire), [
            'ouvrage_id' => $this->ouvrage->id,
            'code_barre' => $exemplaire->code_barre,
            'statut' => \App\Enums\StatutExemplaire::PERDU->value,
            'etat' => 1
        ]);
        
    $response->assertRedirect(route('admin.exemplaires.show', $exemplaire));
    
    $exemplaire->refresh();
    expect($exemplaire->statut)->toBe(\App\Enums\StatutExemplaire::PERDU);
});
