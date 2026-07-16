<?php

namespace App\Repositories\Contracts;

use App\Models\Adherent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AdherentRepositoryInterface
{
    public function all(): Collection;
    
    public function find(int $id): ?Adherent;
    
    public function findByNumCarte(string $numCarte): ?Adherent;
    
    public function findByEmail(string $email): ?Adherent;
    
    public function findByStatut(string $statut): Collection;
    
    public function findExpired(): Collection;
    
    public function findActif(): Collection;
    
    public function canBorrow(int $adherentId): bool;
    
    public function paginer(int $perPage = 15, array $filtres = []): LengthAwarePaginator;
    
    public function create(array $data): Adherent;
    
    public function update(Adherent $adherent, array $data): bool;
    
    public function delete(Adherent $adherent): bool;
}
