<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Adherent\TableauBordController;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');



Route::get('/test-notifications', function () {
    \Illuminate\Support\Facades\Artisan::call('prets:verifier-retards');
    \Illuminate\Support\Facades\Artisan::call('prets:envoyer-rappels', ['jours' => 3]);
    \Illuminate\Support\Facades\Artisan::call('adherents:envoyer-rappels', ['jours' => 7]);
    
    // Forcer le traitement de la file d'attente (Jobs en arrière-plan)
    \Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
    
    return '✅ Vérification et traitement de la file d\'attente effectués ! Les notifications ont été générées.';
});

Route::get('/dashboard', function () {
    $redirect = redirectByRole(auth()->user());
    if ($redirect !== route('home')) {
        return redirect($redirect);
    }
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('logout', function (Logout $logout) {
    $logout();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/forcer-mot-de-passe', [\App\Http\Controllers\Auth\ForcePasswordController::class, 'create'])->name('password.force-change');
    Route::post('/forcer-mot-de-passe', [\App\Http\Controllers\Auth\ForcePasswordController::class, 'store'])->name('password.force-change.store');
});

require __DIR__.'/auth.php';
