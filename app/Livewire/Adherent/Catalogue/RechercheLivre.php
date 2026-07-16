<?php

namespace App\Livewire\Adherent\Catalogue;

use App\Models\Categorie;
use App\Models\Ouvrage;
use Livewire\Component;
use Livewire\WithPagination;

class RechercheLivre extends Component
{
    use WithPagination;

    public string $recherche = '';
    public int $categorie_id = 0;
    public string $disponibilite = '';

    protected $queryString = [
        'recherche' => ['except' => ''],
        'categorie_id' => ['except' => 0],
        'disponibilite' => ['except' => ''],
    ];

    public function updatingRecherche()
    {
        $this->resetPage();
    }

    public function updatingCategorieId()
    {
        $this->resetPage();
    }

    public function updatingDisponibilite()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Ouvrage::with(['categories', 'exemplaires'])
            ->when($this->recherche, function ($q) {
                $q->where(function ($subQ) {
                    $subQ->where('titre', 'like', '%' . $this->recherche . '%')
                         ->orWhere('auteurs', 'like', '%' . $this->recherche . '%');
                 });
            })
            ->when($this->categorie_id, function ($q) {
                $q->whereHas('categories', function ($qCat) {
                    $qCat->where('categories.id', $this->categorie_id);
                });
            })
            ->when($this->disponibilite === 'disponible', function ($q) {
                $q->whereHas('exemplaires', function ($qEx) {
                    $qEx->where('statut', 'disponible');
                });
            });

        return view('livewire.adherent.catalogue.recherche-livre', [
            'ouvrages' => $query->paginate(12),
            'categories' => Categorie::orderBy('nom')->get(),
        ]);
    }
}
