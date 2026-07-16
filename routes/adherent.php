<?php

use App\Http\Controllers\Adherent\PretController;
use App\Http\Controllers\Adherent\TableauBordController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:adherent', 'journal', 'force_password_change'])
    ->prefix('mon-compte')
    ->name('adherent.')
    ->group(function () {
        // Changement de mot de passe obligatoire
        Route::get('/forcer-mot-de-passe', [\App\Http\Controllers\Adherent\ForcePasswordController::class, 'create'])->name('password.force-change');
        Route::post('/forcer-mot-de-passe', [\App\Http\Controllers\Adherent\ForcePasswordController::class, 'store'])->name('password.force-change.store');

        Route::get('/tableau-bord', [TableauBordController::class, 'index'])->name('dashboard');

        // ── Module 3 : Mes prêts ───────────────────────────────────────
        Route::get('/prets', [PretController::class, 'index'])->name('prets.index');
        Route::get('/prets/history', [PretController::class, 'history'])->name('prets.history');
        Route::get('/prets/{id}', [PretController::class, 'show'])->name('prets.show');
        Route::post('/prets/{id}/prolonger', [PretController::class, 'prolonger'])->name('prets.prolonger');
        // ── Module 4 : Mes pénalités ───────────────────────────────────
        // ── Module 4 : Mes pénalités ───────────────────────────────────
        Route::get('/penalites', [\App\Http\Controllers\Adherent\PenaliteController::class, 'index'])->name('penalites.index');
        
        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\Adherent\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\Adherent\NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [\App\Http\Controllers\Adherent\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

        // Catalogue
        Route::get('/catalogue', [\App\Http\Controllers\Adherent\CatalogueController::class, 'index'])->name('catalogue.index');
        Route::get('/catalogue/{id}', [\App\Http\Controllers\Adherent\CatalogueController::class, 'show'])->name('catalogue.show');

        // Paramètres & Profil
        Route::get('/profil', [\App\Http\Controllers\Adherent\ProfilController::class, 'index'])->name('profil.index');
        Route::get('/profil/carte', [\App\Http\Controllers\Adherent\ProfilController::class, 'downloadCard'])->name('profil.carte');
        Route::view('/parametres', 'adherent.parametres.index')->name('parametres.index');
    });
