<?php

namespace App\Http\Controllers\Admin;

use App\DTO\PretDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PretRequest;
use App\Http\Requests\RetourRequest;
use App\Models\Pret;
use App\Services\PretService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PretController extends Controller
{
    public function __construct(
        private readonly PretService $pretService,
    ) {}

    public function index(): View
    {
        Gate::authorize('viewAny', Pret::class);
        return view('admin.prets.index');
    }

    public function history(): View
    {
        Gate::authorize('viewAny', Pret::class);
        return view('admin.prets.history');
    }

    public function create(): View
    {
        Gate::authorize('create', Pret::class);
        return view('admin.prets.create');
    }

    public function store(PretRequest $request): RedirectResponse
    {
        Gate::authorize('create', Pret::class);

        try {
            $dto = PretDTO::fromRequest($request->validated());
            $pret = $this->pretService->emprunter($dto);

            return redirect()
                ->route('admin.prets.show', $pret->id)
                ->with('success', 'Prêt enregistré avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }

    public function show(int $id): View
    {
        $pret = $this->pretService->getById($id);
        if (!$pret) {
            abort(404);
        }

        Gate::authorize('view', Pret::find($id));

        return view('admin.prets.show', ['pret' => $pret]);
    }

    public function return(Request $request, int $id): RedirectResponse
    {
        Gate::authorize('return', Pret::find($id));

        try {
            $retourDTO = $this->pretService->retourner($id);

            return redirect()
                ->route('admin.prets.show', $id)
                ->with('success', $retourDTO->message);
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    public function prolonger(int $id): RedirectResponse
    {
        Gate::authorize('prolonger', Pret::find($id));

        try {
            $prolongationDTO = $this->pretService->prolonger($id);

            return redirect()
                ->route('admin.prets.show', $id)
                ->with('success', $prolongationDTO->message);
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }

    public function searchAdherent(Request $request)
    {
        $query = $request->get('q');
        $adherents = \App\Models\Adherent::where('nom', 'LIKE', "%{$query}%")
            ->orWhere('prenom', 'LIKE', "%{$query}%")
            ->orWhere('num_carte', 'LIKE', "%{$query}%")
            ->where('statut', 'actif')
            ->limit(10)
            ->get(['id', 'nom', 'prenom', 'num_carte', 'email']);

        return response()->json($adherents);
    }

    public function searchExemplaire(Request $request)
    {
        $query = $request->get('q');
        $exemplaires = \App\Models\Exemplaire::where('code_barre', 'LIKE', "%{$query}%")
            ->orWhereHas('ouvrage', function ($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                    ->orWhere('auteurs', 'LIKE', "%{$query}%");
            })
            ->where('statut', 'disponible')
            ->limit(10)
            ->with('ouvrage')
            ->get(['id', 'code_barre', 'ouvrage_id']);

        return response()->json($exemplaires);
    }

    public function verifierEligibilite(Request $request, int $adherentId)
    {
        $errors = $this->pretService->verifierEligibilite($adherentId);
        return response()->json([
            'eligible' => empty($errors),
            'errors' => $errors,
        ]);
    }
}
