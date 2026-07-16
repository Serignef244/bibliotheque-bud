<?php

use App\Models\Penalite;
use App\Models\Pret;

it('exposes a penalty relation through the Penalite model', function () {
    expect(method_exists(Pret::class, 'penalite'))->toBeTrue()
        ->and(class_exists(Penalite::class))->toBeTrue();
});
