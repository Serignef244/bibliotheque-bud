<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Adherent\TableauBordController;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// Route temporaire pour nettoyer la base de données sur Render
Route::get('/dev/wipe-db', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
    return 'Base de données réinitialisée avec succès ! Les données de démo ont été supprimées. Seul le compte Admin existe. Vous pouvez retourner à l\'accueil.';
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
