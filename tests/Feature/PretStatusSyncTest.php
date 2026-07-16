<?php

use App\DTO\PretDTO;
use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Models\Ouvrage;
use App\Models\TypeAdherent;
use App\Services\PretService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('la création d’un prêt marque immédiatement l’exemplaire comme emprunté', function () {
    $typeAdherent = TypeAdherent::factory()->create(['max_books' => 3]);
    $adherent = Adherent::factory()->create([
        'type_adherent_id' => $typeAdherent->id,
        'statut' => 'actif',
    ]);
    $ouvrage = Ouvrage::factory()->create();
    $exemplaire = Exemplaire::factory()->create([
        'ouvrage_id' => $ouvrage->id,
        'statut' => 'disponible',
    ]);

    $service = app(PretService::class);
    $pret = $service->emprunter(PretDTO::fromRequest([
        'adherent_id' => $adherent->id,
        'exemplaire_id' => $exemplaire->id,
        'date_emprunt' => now()->toDateString(),
        'remarques' => null,
    ]));

    $exemplaire->refresh();

    expect($pret->id)->toBeInt()
        ->and($exemplaire->statut->value ?? $exemplaire->statut)->toBe('emprunte');
});
