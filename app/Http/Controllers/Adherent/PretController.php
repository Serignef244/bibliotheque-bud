<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use App\Models\Pret;
use App\Services\PretService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PretController extends Controller
{
    public function __construct(
        private readonly PretService $pretService,
    ) {
    }

    public function index(): View
    {
        $adherentId = auth()->user()->adherent?->id;
        if (!$adherentId) {
            abort(403, 'Aucun profil adhérent associé');
        }

        $prets = $this->pretService->getByAdherent($adherentId);
        return view('adherent.prets.index', compact('prets'));
    }

    public function history(): View
    {
        $adherentId = auth()->user()->adherent?->id;
        if (!$adherentId) {
            abort(403, 'Aucun profil adhérent associé');
        }

        $history = $this->pretService->getHistory($adherentId);
        return view('adherent.prets.history', compact('history'));
    }

    public function show(int $id): View
    {
        $pret = $this->pretService->getById($id);
        if (!$pret) {
            abort(404);
        }

        Gate::authorize('view', Pret::find($id));

        return view('adherent.prets.show', ['pret' => $pret]);
    }

    public function prolonger(int $id): RedirectResponse
    {
        $pret = Pret::find($id);
        Gate::authorize('prolonger', $pret);

        try {
            $prolongationDTO = $this->pretService->prolonger($id);

            return redirect()
                ->route('adherent.prets.show', $id)
                ->with('success', $prolongationDTO->message);
        } catch (\Exception $e) {
            return back()->withErrors(['general' => $e->getMessage()]);
        }
    }
}
