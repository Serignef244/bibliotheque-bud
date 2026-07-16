<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CategorieDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategorieRequest;
use App\Models\Categorie;
use App\Services\CategorieService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class CategorieController extends Controller
{
    public function __construct(
        private readonly CategorieService $categorieService,
    ) {
    }

    public function index(): View
    {
        Gate::authorize('viewAny', Categorie::class);
        $arbre = $this->categorieService->listerArbre();
        return view('admin.categories.index', compact('arbre'));
    }

    public function create(): View
    {
        Gate::authorize('create', Categorie::class);
        $parentes = $this->categorieService->listerPourSelecteur();
        return view('admin.categories.create', compact('parentes'));
    }

    public function store(CategorieRequest $request): RedirectResponse
    {
        Gate::authorize('create', Categorie::class);
        try {
            $categorie = $this->categorieService->creer(CategorieDTO::fromRequest($request));
            return redirect()
                ->route('admin.categories.index')
                ->with('success', "Catégorie « {$categorie->nom} » créée avec succès.");
        } catch (\RuntimeException $e) {
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    public function show(Categorie $categorie): View
    {
        Gate::authorize('view', $categorie);
        $categorie->load(['parent', 'enfants', 'ouvrages']);
        return view('admin.categories.show', compact('categorie'));
    }

    public function edit(Categorie $categorie): View
    {
        Gate::authorize('update', $categorie);
        $parentes = $this->categorieService->listerPourSelecteur();
        return view('admin.categories.edit', compact('categorie', 'parentes'));
    }

    public function update(CategorieRequest $request, Categorie $categorie): RedirectResponse
    {
        Gate::authorize('update', $categorie);
        try {
            $this->categorieService->modifier($categorie, CategorieDTO::fromRequest($request));
            return redirect()
                ->route('admin.categories.index')
                ->with('success', "Catégorie « {$categorie->nom} » modifiée avec succès.");
        } catch (\RuntimeException $e) {
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Categorie $categorie): RedirectResponse
    {
        Gate::authorize('delete', $categorie);
        try {
            $nom = $categorie->nom;
            $this->categorieService->supprimer($categorie);
            return redirect()
                ->route('admin.categories.index')
                ->with('success', "Catégorie « {$nom} » supprimée.");
        } catch (\RuntimeException $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }
}
