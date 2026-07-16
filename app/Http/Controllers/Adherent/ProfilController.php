<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfilController extends Controller
{
    public function index()
    {
        $adherent = auth()->user()->adherent;
        return view('adherent.profil.index', compact('adherent'));
    }

    public function downloadCard()
    {
        $adherent = auth()->user()->adherent;
        $pdf = Pdf::loadView('adherent.profil.carte_pdf', compact('adherent'))->setPaper('A4', 'landscape');
        
        return $pdf->download('carte_adherent_' . $adherent->num_carte . '.pdf');
    }
}
