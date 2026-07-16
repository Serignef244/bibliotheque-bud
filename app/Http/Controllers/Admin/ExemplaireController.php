<?php

namespace App\Http\Controllers\Admin;

use App\DTO\ExemplaireDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExemplaireRequest;
use App\Models\Exemplaire;
use App\Models\Ouvrage;
use App\Services\ExemplaireService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class ExemplaireController extends Controller
{
    public function __construct(
        private readonly ExemplaireService $exemplaireService,
    ) {
    }

    public function index(Ouvrage $ouvrage): View
    {
        Gate::authorize('viewAny', Exemplaire::class);
        $exemplaires = $ouvrage->exemplaires()->orderBy('code_barre')->get();
        return view('admin.exemplaires.index', compact('ouvrage', 'exemplaires'));
    }

    public function create(Ouvrage $ouvrage): View
    {
        Gate::authorize('create', Exemplaire::class);
        return view('admin.exemplaires.create', compact('ouvrage'));
    }

    public function store(ExemplaireRequest $request, Ouvrage $ouvrage): RedirectResponse
    {
        Gate::authorize('create', Exemplaire::class);
        $dto = ExemplaireDTO::fromRequest($request);
        $exemplaire = $this->exemplaireService->creer($ouvrage, $dto);

        return redirect()
            ->route('admin.ouvrages.exemplaires.index', $ouvrage)
            ->with('success', "Exemplaire « {$exemplaire->code_barre} » créé.");
    }

    public function show(Exemplaire $exemplaire): View
    {
        Gate::authorize('view', $exemplaire);
        $ouvrage = $exemplaire->ouvrage;
        $svgCodeBarre = $this->exemplaireService->genererImageCodeBarre($exemplaire->code_barre);
        return view('admin.exemplaires.show', compact('ouvrage', 'exemplaire', 'svgCodeBarre'));
    }

    public function edit(Exemplaire $exemplaire): View
    {
        Gate::authorize('update', $exemplaire);
        $ouvrage = $exemplaire->ouvrage;
        return view('admin.exemplaires.edit', compact('ouvrage', 'exemplaire'));
    }

    public function update(ExemplaireRequest $request, Exemplaire $exemplaire): RedirectResponse
    {
        Gate::authorize('update', $exemplaire);
        $dto = ExemplaireDTO::fromRequest($request);
        $this->exemplaireService->modifier($exemplaire, $dto);

        return redirect()
            ->route('admin.ouvrages.exemplaires.index', $exemplaire->ouvrage_id)
            ->with('success', "Exemplaire « {$exemplaire->code_barre} » modifié.");
    }

    public function destroy(Exemplaire $exemplaire): RedirectResponse
    {
        Gate::authorize('delete', $exemplaire);
        try {
            $ouvrageId = $exemplaire->ouvrage_id;
            $this->exemplaireService->supprimer($exemplaire);
            return redirect()
                ->route('admin.ouvrages.exemplaires.index', $ouvrageId)
                ->with('success', "Exemplaire supprimé avec succès.");
        } catch (\RuntimeException $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }
}
