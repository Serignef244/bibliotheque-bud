<?php

namespace App\DTO;

use App\Models\TypeAdherent;

class TypeAdherentDTO
{
    public function __construct(
        public readonly ?int    $id = null,
        public readonly ?string $nom = null,
        public readonly ?string $slug = null,
        public readonly ?int    $duree_jours = null,
        public readonly ?int    $max_books = null,
        public readonly ?int    $tarif_penalite = null,
        public readonly ?string $description = null,
        public readonly int     $adherents_count = 0,
    ) {}

    public static function fromModel(TypeAdherent $model): self
    {
        return new self(
            id: $model->id,
            nom: $model->nom,
            slug: $model->slug,
            duree_jours: $model->duree_jours,
            max_books: $model->max_books,
            tarif_penalite: $model->tarif_penalite,
            description: $model->description,
            adherents_count: $model->adherents_count ?? $model->adherents()->count(),
        );
    }

    public static function fromRequest($request): self
    {
        return new self(
            nom: $request->validated('nom'),
            slug: \Illuminate\Support\Str::slug($request->validated('nom')),
            duree_jours: (int) $request->validated('duree_jours'),
            max_books: (int) $request->validated('max_books'),
            tarif_penalite: (int) $request->validated('tarif_penalite'),
            description: $request->validated('description'),
        );
    }

    public function tarifFormate(): string
    {
        return number_format($this->tarif_penalite ?? 0, 0, ',', ' ') . ' FCFA';
    }

    public function toArray(): array
    {
        return array_filter([
            'nom' => $this->nom,
            'slug' => $this->slug,
            'duree_jours' => $this->duree_jours,
            'max_books' => $this->max_books,
            'tarif_penalite' => $this->tarif_penalite,
            'description' => $this->description,
        ], fn ($value) => $value !== null);
    }
}
