<?php

namespace App\Repositories\Contracts;

use App\Models\TypeAdherent;
use Illuminate\Database\Eloquent\Collection;

interface TypeAdherentRepositoryInterface
{
    public function all(): Collection;
    
    public function find(int $id): ?TypeAdherent;
    
    public function findByNom(string $nom): ?TypeAdherent;
    
    public function getAllWithAdherentsCount(): Collection;
    
    public function create(array $data): TypeAdherent;
    
    public function update(TypeAdherent $typeAdherent, array $data): bool;
    
    public function delete(TypeAdherent $typeAdherent): bool;
}
