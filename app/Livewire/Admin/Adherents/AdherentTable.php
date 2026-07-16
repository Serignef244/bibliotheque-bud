<?php

namespace App\Livewire\Admin\Adherents;

use App\Enums\StatutAdherent;
use App\Models\Adherent;
use App\Models\TypeAdherent;
use Livewire\Component;
use Livewire\WithPagination;

class AdherentTable extends Component
{
    use WithPagination;

    public string $recherche = '';
    public string $statut = '';
    public string $type_adherent_id = '';

    protected $queryString = [
        'recherche' => ['except' => ''],
        'statut' => ['except' => ''],
        'type_adherent_id' => ['except' => ''],
    ];

    public function updatingRecherche(): void
    {
        $this->resetPage();
    }

    public function updatingStatut(): void
    {
        $this->resetPage();
    }

    public function updatingTypeAdherentId(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Adherent::with('typeAdherent');

        if ($this->recherche) {
            $r = $this->recherche;
            $query->where(function ($q) use ($r) {
                $q->where('nom', 'LIKE', "%{$r}%")
                  ->orWhere('prenom', 'LIKE', "%{$r}%")
                  ->orWhere('email', 'LIKE', "%{$r}%")
                  ->orWhere('num_carte', 'LIKE', "%{$r}%");
            });
        }

        if ($this->statut) {
            $query->where('statut', $this->statut);
        }

        if ($this->type_adherent_id) {
            $query->where('type_adherent_id', $this->type_adherent_id);
        }

        $adherents = $query->orderBy('created_at', 'desc')->paginate(15);
        $types = TypeAdherent::all();
        $statuts = StatutAdherent::liste();

        return view('livewire.admin.adherents.adherent-table', compact('adherents', 'types', 'statuts'));
    }
}
