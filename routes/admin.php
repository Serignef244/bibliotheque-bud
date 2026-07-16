<?php

use App\Http\Controllers\Admin\AdherentController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExemplaireController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\OuvrageController;
use App\Http\Controllers\Admin\PretController;
use App\Http\Controllers\Admin\TypeAdherentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin,bibliothecaire', 'journal'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ── Module 1 : Gestion des ouvrages ────────────────────────────────
        Route::resource('ouvrages', OuvrageController::class);

        // Exemplaires imbriqués sous un ouvrage
        Route::resource('ouvrages.exemplaires', ExemplaireController::class)
             ->shallow();

        // Catégories
        Route::resource('categories', CategorieController::class);

        // Recherche ISBN (API)
        Route::get('/isbn/search', [\App\Http\Controllers\Admin\ISBNController::class, 'search'])
             ->name('isbn.search');

        // ── Module 2 : Gestion des adhérents ───────────────────────────────
        Route::resource('adherents', AdherentController::class);
        Route::put('adherents/{adherent}/suspendre', [AdherentController::class, 'suspendre'])->name('adherents.suspendre');
        Route::put('adherents/{adherent}/reactiver', [AdherentController::class, 'reactiver'])->name('adherents.reactiver');
        Route::put('adherents/{adherent}/radier', [AdherentController::class, 'radier'])->name('adherents.radier');
        Route::get('adherents/{adherent}/carte', [AdherentController::class, 'carte'])->name('adherents.carte');
        Route::get('adherents/{adherent}/history', [AdherentController::class, 'history'])->name('adherents.history');

        // Types d'adhérents
        Route::resource('types-adherents', TypeAdherentController::class);

        // ── Module 3 : Gestion des prêts ───────────────────────────────────
        Route::get('/prets', [PretController::class, 'index'])->name('prets.index');
        Route::get('/prets/history', [PretController::class, 'history'])->name('prets.history');
        Route::get('/prets/create', [PretController::class, 'create'])->name('prets.create');
        Route::post('/prets', [PretController::class, 'store'])->name('prets.store');
        Route::get('/prets/{id}', [PretController::class, 'show'])->name('prets.show');
        Route::post('/prets/{id}/return', [PretController::class, 'return'])->name('prets.return');
        Route::post('/prets/{id}/prolonger', [PretController::class, 'prolonger'])->name('prets.prolonger');

        // API pour les recherches AJAX
        Route::get('/api/prets/search/adherent', [PretController::class, 'searchAdherent'])->name('api.prets.search.adherent');
        Route::get('/api/prets/search/exemplaire', [PretController::class, 'searchExemplaire'])->name('api.prets.search.exemplaire');
        Route::get('/api/prets/verifier/{id}', [PretController::class, 'verifierEligibilite'])->name('api.prets.verifier');
        // ── Module 4 : Gestion des pénalités ───────────────────────────────
        Route::get('/penalites', [\App\Http\Controllers\Admin\PenaliteController::class, 'index'])->name('penalites.index');
        Route::get('/penalites/{penalite}', [\App\Http\Controllers\Admin\PenaliteController::class, 'show'])->name('penalites.show');
        Route::post('/penalites/{penalite}/payer', [\App\Http\Controllers\Admin\PenaliteController::class, 'payer'])->name('penalites.payer');
        Route::get('/penalites/{penalite}/recu', [\App\Http\Controllers\Admin\PenaliteController::class, 'recu'])->name('penalites.recu');
        Route::view('/statistiques', 'admin.placeholder', ['title' => 'Statistiques'])->name('statistiques.index');
        Route::view('/utilisateurs', 'admin.placeholder', ['title' => 'Administration'])->name('utilisateurs.index');
        Route::view('/parametres', 'admin.placeholder', ['title' => 'Paramètres'])->name('parametres.index');

        Route::get('/logs', [JournalController::class, 'index'])->name('logs.index');
    });
