<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$e = \App\Models\Exemplaire::find(2);
echo "Avant: " . $e->statut->value . "\n";
$e->update(['statut' => \App\Enums\StatutExemplaire::EMPRUNTE]);
echo "Après: " . $e->statut->value . "\n";
