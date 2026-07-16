<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = app(\App\Services\PretService::class);
$dto = \App\DTO\PretDTO::fromRequest([
    'adherent_id' => 1,
    'exemplaire_id' => 2,
    'date_emprunt' => now()->toDateString(),
    'remarques' => 'Test loan',
]);

try {
    $pret = $service->emprunter($dto);
    echo "Pret created: " . $pret->id . "\n";
    $o = \App\Models\Ouvrage::find(2);
    echo "Disponibles after loan: " . $o->nombre_exemplaires_disponibles . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
