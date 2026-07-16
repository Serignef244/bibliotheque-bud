<?php

namespace App\Http\Controllers\Admin;

use App\DTO\OuvrageDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\OuvrageRequest;
use App\Models\Ouvrage;
use App\Services\CategorieService;
use App\Services\OuvrageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class OuvrageController extends Controller
{
    public function __construct(
        private readonly OuvrageService  $ouvrageService,
        private readonly CategorieService $categorieService,
    ) {
    }

    public function index(): View
    {
        Gate::authorize('viewAny', Ouvrage::class);
        return view('admin.ouvrages.index');
    }

    public function create(): View
    {
        Gate::authorize('create', Ouvrage::class);
        $categories = $this->categorieService->listerPourSelecteur();
        return view('admin.ouvrages.create', compact('categories'));
    }

    public function store(OuvrageRequest $request): RedirectResponse
    {
        Gate::authorize('create', Ouvrage::class);
        try {
            $dto     = OuvrageDTO::fromRequest($request);
            $fichier = $request->hasFile('image_couverture') ? $request->file('image_couverture') : null;
            $ouvrage = $this->ouvrageService->creer($dto, $fichier);

            return redirect()
                ->route('admin.ouvrages.show', $ouvrage)
                ->with('success', "Ouvrage « {$ouvrage->titre} » créé avec succès.");
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    public function show(Ouvrage $ouvrage): View
    {
        Gate::authorize('view', $ouvrage);
        $ouvrage->load(['categories', 'exemplaires']);
        return view('admin.ouvrages.show', compact('ouvrage'));
    }

    public function edit(Ouvrage $ouvrage): View
    {
        Gate::authorize('update', $ouvrage);
        $ouvrage->load(['categories', 'exemplaires']);
        $categories = $this->categorieService->listerPourSelecteur();
        $categoriesSelectionnees = $ouvrage->categories->pluck('id')->toArray();
        $categoriePrincipaleId   = $ouvrage->categories->firstWhere('pivot.principale', true)?->id;

        return view('admin.ouvrages.edit', compact(
            'ouvrage',
            'categories',
            'categoriesSelectionnees',
            'categoriePrincipaleId',
        ));
    }

    public function update(OuvrageRequest $request, Ouvrage $ouvrage): RedirectResponse
    {
        Gate::authorize('update', $ouvrage);
        try {
            $dto     = OuvrageDTO::fromRequest($request);
            $fichier = $request->hasFile('image_couverture') ? $request->file('image_couverture') : null;
            $this->ouvrageService->modifier($ouvrage, $dto, $fichier);

            return redirect()
                ->route('admin.ouvrages.show', $ouvrage)
                ->with('success', "Ouvrage « {$ouvrage->titre} » modifié avec succès.");
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Ouvrage $ouvrage): RedirectResponse
    {
        Gate::authorize('delete', $ouvrage);
        try {
            $titre = $ouvrage->titre;
            $this->ouvrageService->supprimer($ouvrage);
            return redirect()
                ->route('admin.ouvrages.index')
                ->with('success', "Ouvrage « {$titre} » supprimé.");
        } catch (\RuntimeException $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }
}
