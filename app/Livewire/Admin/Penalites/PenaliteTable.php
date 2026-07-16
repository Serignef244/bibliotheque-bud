<?php

namespace App\Livewire\Admin\Penalites;

use App\Enums\StatutPenalite;
use App\Models\Penalite;
use Livewire\Component;
use Livewire\WithPagination;

class PenaliteTable extends Component
{
    use WithPagination;

    public string $recherche = '';
    public string $statut = '';

    protected $queryString = [
        'recherche' => ['except' => ''],
        'statut' => ['except' => ''],
    ];

    public function updatingRecherche()
    {
        $this->resetPage();
    }

    public function updatingStatut()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Penalite::with(['adherent', 'pret.exemplaire.ouvrage'])
            ->when($this->statut, function ($q) {
                $q->where('statut', $this->statut);
            })
            ->when($this->recherche, function ($q) {
                $q->whereHas('adherent', function ($query) {
                    $query->where('nom', 'like', '%' . $this->recherche . '%')
                          ->orWhere('prenom', 'like', '%' . $this->recherche . '%')
                          ->orWhere('num_carte', 'like', '%' . $this->recherche . '%');
                });
            })
            ->latest();

        $statistiques = [
            'total_impaye' => Penalite::where('statut', StatutPenalite::IMPAYE->value)->sum('montant_restant'),
            'ce_mois' => Penalite::whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year)
                                 ->sum('montant'),
            'adherents_bloques' => Penalite::where('statut', StatutPenalite::IMPAYE->value)
                                           ->select('adherent_id')
                                           ->distinct()
                                           ->get()
                                           ->filter(function($penalite) {
                                               return app(\App\Services\PenaliteService::class)->estBloque($penalite->adherent_id);
                                           })->count(),
        ];

        return view('livewire.admin.penalites.penalite-table', [
            'penalites' => $query->paginate(10),
            'statuts' => StatutPenalite::liste(),
            'statistiques' => $statistiques,
        ]);
    }
}
