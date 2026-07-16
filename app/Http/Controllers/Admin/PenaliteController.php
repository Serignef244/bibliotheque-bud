<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penalite;
use App\Services\PenaliteService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PenaliteController extends Controller
{
    public function __construct(
        private readonly PenaliteService $penaliteService,
    ) {}

    public function index()
    {
        return view('admin.penalites.index');
    }

    public function show(Penalite $penalite)
    {
        $penalite->load(['pret.exemplaire.ouvrage', 'adherent.typeAdherent', 'paiements']);
        return view('admin.penalites.show', compact('penalite'));
    }

    public function payer(Request $request, Penalite $penalite)
    {
        $request->validate([
            'montant' => ['required', 'integer', 'min:1', 'max:' . $penalite->montant_restant],
        ]);

        $this->penaliteService->enregistrerPaiement($penalite, $request->montant);

        return redirect()->route('admin.penalites.show', $penalite)
            ->with('success', 'Le paiement a été enregistré avec succès.');
    }

    public function recu(Penalite $penalite)
    {
        $penalite->load(['pret.exemplaire.ouvrage', 'adherent.typeAdherent', 'paiements']);
        
        // Prendre le dernier paiement pour le reçu
        $paiement = $penalite->paiements()->latest()->first();

        if (!$paiement) {
            return redirect()->back()->with('error', 'Aucun paiement trouvé pour cette pénalité.');
        }

        $pdf = Pdf::loadView('admin.penalites.recu_pdf', compact('penalite', 'paiement'));
        
        return $pdf->stream('recu_paiement_' . $penalite->id . '.pdf');
    }
}
