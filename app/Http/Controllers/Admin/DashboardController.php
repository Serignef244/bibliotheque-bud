<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Models\Ouvrage;
use App\Models\Adherent;
use App\Models\Pret;
use App\Models\Penalite;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'ouvrages' => Ouvrage::count(),
            'adherents_actifs' => Adherent::where('statut', 'actif')->count(),
            'prets_en_cours' => Pret::whereNull('date_retour_reelle')->count(),
            'penalites_impayees' => Penalite::where('statut', 'impaye')->count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}
