<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
echo \App\Models\Exemplaire::find(2)->statut->value . "\n";
$o = \App\Models\Ouvrage::find(2);
echo "Disponibles: " . $o->nombre_exemplaires_disponibles . "\n";
