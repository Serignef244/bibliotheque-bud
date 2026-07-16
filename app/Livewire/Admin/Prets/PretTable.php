<?php

namespace App\Livewire\Admin\Prets;

use App\Models\Pret;
use Livewire\Component;
use Livewire\WithPagination;

class PretTable extends Component
{
    use WithPagination;

    public string $recherche = '';
    public string $statut = '';
    public string $adherent_id = '';

    protected $queryString = [
        'recherche' => ['except' => ''],
        'statut' => ['except' => ''],
        'adherent_id' => ['except' => ''],
    ];

    public function updatingRecherche(): void
    {
        $this->resetPage();
    }

    public function updatingStatut(): void
    {
        $this->resetPage();
    }

    public function updatingAdherentId(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Pret::with(['adherent', 'exemplaire.ouvrage']);

        if ($this->recherche) {
            $r = $this->recherche;
            $query->where(function ($q) use ($r) {
                $q->whereHas('adherent', function ($q) use ($r) {
                    $q->where('nom', 'LIKE', "%{$r}%")
                      ->orWhere('prenom', 'LIKE', "%{$r}%")
                      ->orWhere('num_carte', 'LIKE', "%{$r}%");
                })->orWhereHas('exemplaire.ouvrage', function ($q) use ($r) {
                    $q->where('titre', 'LIKE', "%{$r}%")
                      ->orWhere('auteurs', 'LIKE', "%{$r}%");
                });
            });
        }

        if ($this->statut) {
            $query->where('statut', $this->statut);
        }

        if ($this->adherent_id) {
            $query->where('adherent_id', $this->adherent_id);
        }

        $prets = $query->orderBy('date_emprunt', 'desc')->paginate(15);

        return view('livewire.admin.prets.pret-table', compact('prets'));
    }
}
