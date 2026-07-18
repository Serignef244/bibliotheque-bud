<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Adherent\TableauBordController;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

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

Route::get('/dev/clear-adherents', function () {
    if (request('key') !== 'super-secret-123') {
        abort(403);
    }
    
    // Récupérer les IDs utilisateurs associés aux adhérents
    $userIds = \App\Models\Adherent::withTrashed()->whereNotNull('user_id')->pluck('user_id');
    
    // Supprimer les adhérents
    \App\Models\Adherent::withTrashed()->forceDelete();
    
    // Supprimer les comptes utilisateurs associés
    \App\Models\User::whereIn('id', $userIds)->forceDelete();
    
    return 'Tous les adhérents de test (et leurs comptes) ont été supprimés définitivement !';
});

require __DIR__.'/auth.php';
