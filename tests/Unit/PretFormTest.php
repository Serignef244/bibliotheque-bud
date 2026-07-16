<?php

use App\Livewire\Admin\Prets\PretForm;

it('bloque la soumission tant que les champs requis ne sont pas remplis', function () {
    $component = new PretForm();

    $component->adherent_id = '';
    $component->exemplaire_id = '10';
    $component->date_emprunt = now()->toDateString();
    $component->eligibilityErrors = [];

    expect($component->getCanSubmitProperty())->toBeFalse();
});

it('autorise la soumission quand les champs requis sont présents et sans erreur d’éligibilité', function () {
    $component = new PretForm();

    $component->adherent_id = '1';
    $component->exemplaire_id = '10';
    $component->date_emprunt = now()->toDateString();
    $component->eligibilityErrors = [];

    expect($component->getCanSubmitProperty())->toBeTrue();
});
