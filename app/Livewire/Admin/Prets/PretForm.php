<?php

namespace App\Livewire\Admin\Prets;

use App\DTO\PretDTO;
use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Services\PretService;
use App\Services\VerificationService;
use Livewire\Component;

class PretForm extends Component
{
    public $adherent_id = '';
    public $exemplaire_id = '';
    public $date_emprunt = '';
    public $remarques = '';

    public $selectedAdherent = null;
    public $selectedExemplaire = null;
    public $eligibilityErrors = [];

    public function mount(): void
    {
        $this->date_emprunt = now()->toDateString();
    }

    public function getCanSubmitProperty(): bool
    {
        return filled($this->adherent_id)
            && filled($this->exemplaire_id)
            && filled($this->date_emprunt)
            && empty($this->eligibilityErrors);
    }

    public function updatedAdherentId(): void
    {
        if ($this->adherent_id) {
            $this->selectedAdherent = Adherent::find($this->adherent_id);
            $verificationService = app(VerificationService::class);
            $this->eligibilityErrors = $verificationService->getVerificationErrors($this->adherent_id);
        } else {
            $this->selectedAdherent = null;
            $this->eligibilityErrors = [];
        }
    }

    public function updatedExemplaireId(): void
    {
        if ($this->exemplaire_id) {
            $this->selectedExemplaire = Exemplaire::with('ouvrage')->find($this->exemplaire_id);
        } else {
            $this->selectedExemplaire = null;
        }
    }

    public function getExemplairesDisponiblesProperty()
    {
        return Exemplaire::whereIn('statut', ['disponible'])
            ->with('ouvrage')
            ->orderBy('code_barre')
            ->get();
    }

    public function submit(): mixed
    {
        $this->validate([
            'adherent_id' => 'required|exists:adherents,id',
            'exemplaire_id' => 'required|exists:exemplaires,id',
            'date_emprunt' => 'required|date',
            'remarques' => 'nullable|string|max:1000',
        ]);

        if (!empty($this->eligibilityErrors)) {
            $this->addError('general', 'L\'adhérent n\'est pas éligible pour un prêt.');
            return null;
        }

        $verificationService = app(VerificationService::class);
        if (!$verificationService->isExemplaireDisponible($this->exemplaire_id)) {
            $this->addError('exemplaire_id', 'Cet exemplaire n\'est pas disponible.');
            return null;
        }

        try {
            $dto = PretDTO::fromRequest([
                'adherent_id' => $this->adherent_id,
                'exemplaire_id' => $this->exemplaire_id,
                'date_emprunt' => $this->date_emprunt,
                'remarques' => $this->remarques,
            ]);

            $pret = app(PretService::class)->emprunter($dto);

            $this->reset(['adherent_id', 'exemplaire_id', 'date_emprunt', 'remarques', 'selectedAdherent', 'selectedExemplaire', 'eligibilityErrors']);
            $this->date_emprunt = now()->toDateString();

            return redirect()->route('admin.prets.show', $pret->id);
        } catch (\Throwable $e) {
            $this->addError('general', $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.admin.prets.pret-form');
    }
}
