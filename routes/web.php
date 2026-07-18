<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Adherent\TableauBordController;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

// ROUTE TEMPORAIRE POUR SUPPRIMER LES ADHERENTS
Route::get('/dev/clear-adherents', function () {
    \App\Models\HistoriquePret::query()->delete();
    \App\Models\Pret::query()->delete();
    \App\Models\Adherent::withTrashed()->forceDelete();
    
    $adherentRole = \Spatie\Permission\Models\Role::where('name', 'adherent')->first();
    if ($adherentRole) {
        $users = \App\Models\User::role('adherent')->get();
        foreach($users as $user) {
            $user->delete();
        }
    }
    
    return 'Tous les adhérents, prêts et utilisateurs associés ont été supprimés avec succès !';
});

Route::get('/dev/logs', function () {
    $path = storage_path('logs/laravel.log');
    if (!file_exists($path)) return 'No logs found.';
    return response()->file($path, ['Content-Type' => 'text/plain']);
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
