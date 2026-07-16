<?php

namespace App\Repositories\Eloquent;

use App\Models\TypeAdherent;
use App\Repositories\Contracts\TypeAdherentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TypeAdherentRepository implements TypeAdherentRepositoryInterface
{
    public function all(): Collection
    {
        return TypeAdherent::all();
    }
    
    public function find(int $id): ?TypeAdherent
    {
        return TypeAdherent::find($id);
    }
    
    public function findByNom(string $nom): ?TypeAdherent
    {
        return TypeAdherent::where('nom', $nom)->first();
    }
    
    public function getAllWithAdherentsCount(): Collection
    {
        return TypeAdherent::withCount('adherents')->get();
    }
    
    public function create(array $data): TypeAdherent
    {
        return TypeAdherent::create($data);
    }
    
    public function update(TypeAdherent $typeAdherent, array $data): bool
    {
        return $typeAdherent->update($data);
    }
    
    public function delete(TypeAdherent $typeAdherent): bool
    {
        return $typeAdherent->delete();
    }
}
