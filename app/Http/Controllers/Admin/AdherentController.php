<?php

namespace App\Http\Controllers\Admin;

use App\DTO\AdherentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdherentRequest;
use App\Models\Adherent;
use App\Repositories\Contracts\TypeAdherentRepositoryInterface;
use App\Services\AdherentService;
use App\Services\CarteAdherentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdherentController extends Controller
{
    public function __construct(
        private readonly AdherentService                $adherentService,
        private readonly CarteAdherentService           $carteService,
        private readonly TypeAdherentRepositoryInterface $typeRepository,
    ) {}

    public function index(): View
    {
        Gate::authorize('viewAny', Adherent::class);
        return view('admin.adherents.index');
    }

    public function create(): View
    {
        Gate::authorize('create', Adherent::class);
        $types = $this->typeRepository->all();
        return view('admin.adherents.create', compact('types'));
    }

    public function store(AdherentRequest $request): RedirectResponse
    {
        Gate::authorize('create', Adherent::class);

        try {
            $dto = AdherentDTO::fromRequest($request);
            $photo = $request->hasFile('photo') ? $request->file('photo') : null;
            $adherent = $this->adherentService->creer($dto, $photo);

            return redirect()
                ->route('admin.adherents.show', $adherent)
                ->with('success', "Adhérent « {$adherent->prenom} {$adherent->nom} » inscrit avec succès. Carte : {$adherent->num_carte}");
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    public function show(Adherent $adherent): View
    {
        Gate::authorize('view', $adherent);
        $adherent->load('typeAdherent');
        return view('admin.adherents.show', compact('adherent'));
    }

    public function edit(Adherent $adherent): View
    {
        Gate::authorize('update', $adherent);
        $adherent->load('typeAdherent');
        $types = $this->typeRepository->all();
        return view('admin.adherents.edit', compact('adherent', 'types'));
    }

    public function update(AdherentRequest $request, Adherent $adherent): RedirectResponse
    {
        Gate::authorize('update', $adherent);

        try {
            $dto = AdherentDTO::fromRequest($request);
            $photo = $request->hasFile('photo') ? $request->file('photo') : null;
            $this->adherentService->modifier($adherent, $dto, $photo);

            return redirect()
                ->route('admin.adherents.show', $adherent)
                ->with('success', "Adhérent « {$adherent->prenom} {$adherent->nom} » modifié avec succès.");
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Adherent $adherent): RedirectResponse
    {
        Gate::authorize('delete', $adherent);
        $nom = $adherent->prenom . ' ' . $adherent->nom;
        $this->adherentService->supprimer($adherent);

        return redirect()
            ->route('admin.adherents.index')
            ->with('success', "Adhérent « {$nom} » radié et supprimé.");
    }

    public function suspendre(Adherent $adherent): RedirectResponse
    {
        Gate::authorize('suspend', $adherent);
        $this->adherentService->suspendre($adherent);
        return back()->with('success', "Adhérent « {$adherent->prenom} {$adherent->nom} » suspendu.");
    }

    public function reactiver(Adherent $adherent): RedirectResponse
    {
        Gate::authorize('suspend', $adherent);
        $this->adherentService->reactiver($adherent);
        return back()->with('success', "Adhérent « {$adherent->prenom} {$adherent->nom} » réactivé.");
    }

    public function radier(Request $request, Adherent $adherent): RedirectResponse
    {
        Gate::authorize('delete', $adherent);
        $motif = $request->input('motif', 'Radiation manuelle');
        $this->adherentService->radier($adherent, $motif);
        return back()->with('success', "Adhérent « {$adherent->prenom} {$adherent->nom} » radié.");
    }

    public function carte(Adherent $adherent): BinaryFileResponse
    {
        Gate::authorize('generateCard', $adherent);

        $pdfPath = $this->carteService->generatePDF($adherent);
        $fullPath = \Illuminate\Support\Facades\Storage::disk('public')->path($pdfPath);

        return response()->download($fullPath, "carte_{$adherent->num_carte}.pdf");
    }

    public function history(Adherent $adherent): View
    {
        Gate::authorize('view', $adherent);
        $adherent->load('typeAdherent');
        // Les relations prets et penalites seront ajoutées dans les modules suivants
        return view('admin.adherents.history', compact('adherent'));
    }
}
