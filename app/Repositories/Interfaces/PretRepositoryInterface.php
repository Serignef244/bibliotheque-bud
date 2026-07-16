<?php

namespace App\Repositories\Interfaces;

use App\Models\Pret;
use Illuminate\Database\Eloquent\Collection;

interface PretRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Pret;
    public function create(array $data): Pret;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getCurrentLoans(): Collection;
    public function getLateLoans(): Collection;
    public function getByAdherent(int $adherentId): Collection;
    public function getByExemplaire(int $exemplaireId): Collection;
    public function getHistory(int $adherentId): Collection;
    public function findActiveByExemplaire(int $exemplaireId): ?Pret;
    public function countCurrentByAdherent(int $adherentId): int;
    public function canBorrow(int $adherentId): bool;
    public function paginate(int $perPage = 15, array $filters = []);
}
