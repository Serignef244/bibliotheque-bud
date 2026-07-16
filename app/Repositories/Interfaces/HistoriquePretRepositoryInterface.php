<?php

namespace App\Repositories\Interfaces;

use App\Models\HistoriquePret;
use Illuminate\Database\Eloquent\Collection;

interface HistoriquePretRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?HistoriquePret;
    public function create(array $data): HistoriquePret;
    public function addHistory(int $pretId, string $action, int $userId, array $details = []): HistoriquePret;
    public function getByPret(int $pretId): Collection;
    public function getByAction(string $action): Collection;
    public function getByUtilisateur(int $utilisateurId): Collection;
    public function getHistory(?int $pretId = null, ?string $action = null, ?string $recherche = null, int $perPage = 15);
}
