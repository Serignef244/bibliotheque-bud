<?php

namespace App\Livewire\Admin\Adherents;

use App\DTO\AdherentDTO;
use App\Models\Adherent;
use App\Models\TypeAdherent;
use App\Services\AdherentService;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdherentForm extends Component
{
    use WithFileUploads;

    public ?Adherent $adherent = null;
    public AdherentDTO $dto;
    public $photo;

    public array $types = [];

    protected $rules = [
        'dto.type_adherent_id' => 'required|exists:type_adherents,id',
        'dto.nom' => 'required|string|max:255',
        'dto.prenom' => 'required|string|max:255',
        'dto.email' => 'required|email|unique:adherents,email',
        'dto.telephone' => 'nullable|string|max:20',
        'dto.adresse' => 'nullable|string',
        'dto.date_naissance' => 'nullable|date',
        'dto.statut' => 'nullable|string',
        'dto.motif_radiation' => 'nullable|string',
        'photo' => 'nullable|image|max:2048',
    ];

    public function mount(?Adherent $adherent = null): void
    {
        $this->adherent = $adherent;
        $this->types = TypeAdherent::all()->toArray();

        if ($adherent) {
            $this->dto = AdherentDTO::fromModel($adherent);
            $this->rules['dto.email'] = 'required|email|unique:adherents,email,' . $adherent->id;
        } else {
            $this->dto = new AdherentDTO();
        }
    }

    public function save(AdherentService $service): void
    {
        $this->validate();

        try {
            if ($this->adherent) {
                $service->modifier($this->adherent, $this->dto, $this->photo);
                session()->flash('success', 'Adhérent modifié avec succès.');
            } else {
                $service->creer($this->dto, $this->photo);
                session()->flash('success', 'Adhérent inscrit avec succès.');
            }

            $this->redirect(route('admin.adherents.index'));
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.adherents.adherent-form');
    }
}
