<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use App\Services\PenaliteService;
use App\Services\PretService;
use Illuminate\View\View;

class TableauBordController extends Controller
{
    public function __construct(
        private readonly PretService $pretService,
        private readonly PenaliteService $penaliteService,
    ) {}

    public function index(): View
    {
        $adherent = auth()->user()->adherent;

        if (!$adherent) {
            abort(403, 'Profil adhérent introuvable.');
        }

        // Prêts en cours
        $pretsEnCours = $this->pretService->getByAdherent($adherent->id);
        $quota = $adherent->typeAdherent->max_books ?? 0;
        
        // Pénalités
        $totalImpaye = $this->penaliteService->getTotalImpaye($adherent->id);
        $penalites = $this->penaliteService->getPenalitesByAdherent($adherent->id)->filter->isUnpaid();

        // Récupérer quelques recommandations aléatoires (ouvrages récents)
        $recommandations = \App\Models\Ouvrage::whereHas('exemplaires', function($q) {
                $q->where('statut', 'disponible');
            })
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('adherent.tableau-bord.index', compact(
            'adherent', 
            'pretsEnCours', 
            'quota', 
            'totalImpaye', 
            'penalites',
            'recommandations'
        ));
    }
}
