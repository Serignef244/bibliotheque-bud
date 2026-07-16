<?php

namespace App\DTO;

use Illuminate\Http\Request;

final class CategorieDTO
{
    public function __construct(
        public readonly string $nom,
        public readonly ?string $description,
        public readonly ?int $parentId,
        public readonly int $ordre,
        public readonly bool $actif,
        public readonly ?string $slug = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            nom:         $request->string('nom')->toString(),
            description: $request->input('description'),
            parentId:    $request->integer('parent_id') ?: null,
            ordre:       $request->integer('ordre', 0),
            actif:       $request->boolean('actif', true),
            slug:        $request->input('slug'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nom:         $data['nom'],
            description: $data['description'] ?? null,
            parentId:    $data['parent_id'] ?? null,
            ordre:       $data['ordre'] ?? 0,
            actif:       $data['actif'] ?? true,
            slug:        $data['slug'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'nom'         => $this->nom,
            'description' => $this->description,
            'parent_id'   => $this->parentId,
            'ordre'       => $this->ordre,
            'actif'       => $this->actif,
            'slug'        => $this->slug,
        ], fn ($v) => ! is_null($v));
    }
}
