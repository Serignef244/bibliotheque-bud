<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use App\Services\PenaliteService;
use Illuminate\Http\Request;

class PenaliteController extends Controller
{
    public function __construct(
        private readonly PenaliteService $penaliteService,
    ) {}

    public function index()
    {
        // Supposons que l'adhérent connecté a un id récupérable.
        // Pour ce projet, il semble qu'on utilise un simple 'auth()->id()' si l'utilisateur a un 'adherent_id'
        // ou auth()->user()->adherent->id.
        // Simulons un accès propre via l'utilisateur connecté :
        
        $adherent = auth()->user()->adherent ?? null;

        if (!$adherent) {
            abort(403, 'Profil adhérent non trouvé.');
        }

        $penalites = $this->penaliteService->getPenalitesByAdherent($adherent->id);
        $totalImpaye = $this->penaliteService->getTotalImpaye($adherent->id);
        $estBloque = $this->penaliteService->estBloque($adherent->id);

        return view('adherent.penalites.index', compact('penalites', 'totalImpaye', 'estBloque'));
    }
}
