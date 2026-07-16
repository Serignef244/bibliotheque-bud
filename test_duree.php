<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$t = \App\Models\TypeAdherent::first();
echo "Type: " . $t->nom . "\n";
echo "Duree: " . $t->duree_jours . "\n";
$a = \App\Models\Adherent::first();
echo "Adherent type duree: " . $a->typeAdherent->duree_jours . "\n";
