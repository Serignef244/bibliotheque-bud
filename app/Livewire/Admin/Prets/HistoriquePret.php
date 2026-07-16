<?php

namespace App\Livewire\Admin\Prets;

use App\Repositories\Interfaces\HistoriquePretRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

class HistoriquePret extends Component
{
    use WithPagination;

    public string $recherche = '';
    public string $action = '';
    public int $pret_id = 0;

    protected $queryString = [
        'recherche' => ['except' => ''],
        'action' => ['except' => ''],
        'pret_id' => ['except' => 0],
    ];

    public function updatingRecherche(): void
    {
        $this->resetPage();
    }

    public function updatingAction(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $historiqueRepository = app(HistoriquePretRepositoryInterface::class);
        $historique = $historiqueRepository->getHistory(
            $this->pret_id ?: null,
            $this->action ?: null,
            $this->recherche ?: null,
            15
        );

        return view('livewire.admin.prets.historique-pret', compact('historique'));
    }
}
