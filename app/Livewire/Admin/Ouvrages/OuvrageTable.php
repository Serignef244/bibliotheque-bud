<?php

namespace App\Livewire\Admin\Ouvrages;

use App\Models\Ouvrage;
use App\Models\Categorie;
use Livewire\Component;
use Livewire\WithPagination;

class OuvrageTable extends Component
{
    use WithPagination;

    public $recherche = '';
    public $categorie_id = '';
    public $disponible = '';

    protected $queryString = [
        'recherche' => ['except' => ''],
        'categorie_id' => ['except' => ''],
        'disponible' => ['except' => ''],
    ];

    public function updatingRecherche()
    {
        $this->resetPage();
    }

    public function updatingCategorieId()
    {
        $this->resetPage();
    }

    public function updatingDisponible()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['recherche', 'categorie_id', 'disponible']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Ouvrage::with(['categories', 'exemplaires']);

        if ($this->recherche) {
            $query->where(function($q) {
                $q->where('titre', 'like', '%' . $this->recherche . '%')
                  ->orWhere('auteurs', 'like', '%' . $this->recherche . '%')
                  ->orWhere('isbn', 'like', '%' . $this->recherche . '%');
            });
        }

        if ($this->categorie_id) {
            $query->whereHas('categories', function($q) {
                $q->where('categories.id', $this->categorie_id);
            });
        }

        if ($this->disponible) {
            $query->where('nombre_exemplaires_disponibles', '>', 0);
        }

        $ouvrages = $query->orderBy('titre')->paginate(10);
        
        $categories = Categorie::orderBy('nom')->get();

        return view('livewire.admin.ouvrages.ouvrage-table', [
            'ouvrages' => $ouvrages,
            'categories' => $categories
        ]);
    }
}
