<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use App\Models\Ouvrage;

class CatalogueController extends Controller
{
    public function index()
    {
        return view('adherent.catalogue.index');
    }

    public function show($id)
    {
        $ouvrage = Ouvrage::with(['categories', 'exemplaires' => function($q) {
            $q->orderBy('code_barre');
        }])->findOrFail($id);

        $similaires = Ouvrage::whereHas('categories', function($q) use ($ouvrage) {
                $q->whereIn('categories.id', $ouvrage->categories->pluck('id'));
            })
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('adherent.catalogue.show', compact('ouvrage', 'similaires'));
    }
}
