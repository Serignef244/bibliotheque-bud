<?php

namespace App\Services;

use App\DTO\PretDTO;
use App\DTO\RetourDTO;
use App\DTO\ProlongationDTO;
use App\Events\LivreRetourne;
use App\Events\PretEffectue;
use App\Events\PretProlonge;
use App\Models\Adherent;
use App\Models\Exemplaire;
use App\Models\Pret;
use App\Repositories\Interfaces\HistoriquePretRepositoryInterface;
use App\Repositories\Interfaces\PretRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class PretService
{
    public function __construct(
        private readonly PretRepositoryInterface $pretRepository,
        private readonly HistoriquePretRepositoryInterface $historiqueRepository,
        private readonly VerificationService $verificationService,
        private readonly RetourService $retourService,
        private readonly ProlongationService $prolongationService,
    ) {}

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->pretRepository->all();
    }

    public function getCurrentLoans(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->pretRepository->getCurrentLoans();
    }

    public function getLateLoans(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->pretRepository->getLateLoans();
    }

    public function getById(int $id): ?Pret
    {
        return $this->pretRepository->find($id);
    }

    public function getByAdherent(int $adherentId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->pretRepository->getByAdherent($adherentId);
    }

    public function getHistory(int $adherentId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->pretRepository->getHistory($adherentId);
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->pretRepository->paginate($perPage, $filters);
    }

    public function emprunter(PretDTO $dto): PretDTO
    {
        $errors = $this->verificationService->getVerificationErrors($dto->adherent_id);
        if (!empty($errors)) {
            throw new \Exception(implode(', ', $errors));
        }

        if (!$this->verificationService->isExemplaireDisponible($dto->exemplaire_id)) {
            throw new \Exception('Cet exemplaire n\'est pas disponible');
        }

        $adherent = Adherent::with('typeAdherent')->find($dto->adherent_id);
        $dureePret = \App\Models\Setting::get('pret_duree', 14);
        $dateRetourPrevue = now()->addDays($dureePret);

        $pret = $this->pretRepository->create([
            'adherent_id' => $dto->adherent_id,
            'exemplaire_id' => $dto->exemplaire_id,
            'date_emprunt' => $dto->date_emprunt ?? now(),
            'date_retour_prevue' => $dateRetourPrevue,
            'statut' => 'en_cours',
            'remarques' => $dto->remarques,
        ]);

        $pret->load('adherent', 'exemplaire.ouvrage');

        $exemplaire = $pret->exemplaire;
        if ($exemplaire) {
            $exemplaire->update([
                'statut' => 'emprunte',
                'date_emprunt' => $dto->date_emprunt ?? now(),
            ]);
        }

        event(new PretEffectue($pret, $pret->adherent, $pret->exemplaire));

        return PretDTO::fromModel($pret);
    }

    public function retourner(int $pretId): RetourDTO
    {
        $pret = $this->pretRepository->find($pretId);
        if (!$pret) {
            throw new \Exception('Prêt non trouvé');
        }

        if ($pret->statut === 'rendu') {
            throw new \Exception('Ce prêt a déjà été rendu');
        }

        $retourDTO = $this->retourService->enregistrerRetour($pret);

        event(new LivreRetourne($pret, $pret->adherent, $pret->exemplaire, $retourDTO));

        return $retourDTO;
    }

    public function prolonger(int $pretId): ProlongationDTO
    {
        $pret = $this->pretRepository->find($pretId);
        if (!$pret) {
            throw new \Exception('Prêt non trouvé');
        }

        $raisonsRefus = $this->prolongationService->getRaisonsRefus($pret);
        if (!empty($raisonsRefus)) {
            return ProlongationDTO::refuse($pretId, implode(', ', $raisonsRefus));
        }

        $prolongePret = $this->prolongationService->prolonger($pret);

        event(new PretProlonge($pret, $pret->adherent, ProlongationDTO::create($pretId, $prolongePret->date_retour_prevue)));

        return ProlongationDTO::create($pretId, $prolongePret->date_retour_prevue);
    }

    public function verifierEligibilite(int $adherentId): array
    {
        return $this->verificationService->getVerificationErrors($adherentId);
    }

    public function getDisponibles(int $ouvrageId): int
    {
        $total = Exemplaire::where('ouvrage_id', $ouvrageId)->count();
        $empruntes = Pret::whereHas('exemplaire', function ($q) use ($ouvrageId) {
            $q->where('ouvrage_id', $ouvrageId);
        })->whereIn('statut', ['en_cours', 'retard'])->count();

        return max(0, $total - $empruntes);
    }
}
