<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use App\Services\CarteAdherentService;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $adherent = auth()->user()->adherent;
        return view('adherent.profil.index', compact('adherent'));
    }

    public function downloadCard(CarteAdherentService $carteAdherentService)
    {
        $adherent = auth()->user()->adherent;
        $path = $carteAdherentService->generatePDF($adherent);
        
        return Storage::disk('public')->download($path, 'carte_adherent_' . $adherent->num_carte . '.pdf');
    }
}
