<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'serignef244@gmail.com')->first();
if ($user) {
    $user->password = Hash::make('password');
    $user->save();
    echo "Password changed to: password\n";
} else {
    echo "User serigne not found\n";
}

$adherentTest = App\Models\Adherent::where('email', 'test@adherent.com')->first();
if ($adherentTest) {
    // Delete user if exists
    if ($adherentTest->user_id) {
        App\Models\User::where('id', $adherentTest->user_id)->delete();
    }
    $adherentTest->delete();
    echo "Adherent test deleted\n";
} else {
    echo "Adherent test not found\n";
}
