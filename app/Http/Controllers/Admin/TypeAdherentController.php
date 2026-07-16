<?php

namespace App\Http\Controllers\Admin;

use App\DTO\TypeAdherentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\TypeAdherentRequest;
use App\Models\TypeAdherent;
use App\Repositories\Contracts\TypeAdherentRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TypeAdherentController extends Controller
{
    public function __construct(
        private readonly TypeAdherentRepositoryInterface $repository,
    ) {}

    public function index(): View
    {
        Gate::authorize('viewAny', TypeAdherent::class);
        $types = $this->repository->getAllWithAdherentsCount();
        return view('admin.types-adherents.index', compact('types'));
    }

    public function create(): View
    {
        Gate::authorize('create', TypeAdherent::class);
        return view('admin.types-adherents.create');
    }

    public function store(TypeAdherentRequest $request): RedirectResponse
    {
        Gate::authorize('create', TypeAdherent::class);
        $dto = TypeAdherentDTO::fromRequest($request);
        $this->repository->create($dto->toArray());

        return redirect()
            ->route('admin.types-adherents.index')
            ->with('success', 'Type d\'adhérent créé avec succès.');
    }

    public function edit(TypeAdherent $types_adherent): View
    {
        Gate::authorize('update', $types_adherent);
        return view('admin.types-adherents.edit', ['type' => $types_adherent]);
    }

    public function update(TypeAdherentRequest $request, TypeAdherent $types_adherent): RedirectResponse
    {
        Gate::authorize('update', $types_adherent);
        $dto = TypeAdherentDTO::fromRequest($request);
        $this->repository->update($types_adherent, $dto->toArray());

        return redirect()
            ->route('admin.types-adherents.index')
            ->with('success', 'Type d\'adhérent modifié avec succès.');
    }

    public function destroy(TypeAdherent $types_adherent): RedirectResponse
    {
        Gate::authorize('delete', $types_adherent);

        if ($types_adherent->adherents()->count() > 0) {
            return back()->withErrors(['general' => 'Impossible de supprimer un type qui a des adhérents associés.']);
        }

        $this->repository->delete($types_adherent);

        return redirect()
            ->route('admin.types-adherents.index')
            ->with('success', 'Type d\'adhérent supprimé.');
    }
}
