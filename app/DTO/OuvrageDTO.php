<?php

namespace App\DTO;

use Illuminate\Http\Request;

final class OuvrageDTO
{
    public function __construct(
        public readonly string  $titre,
        public readonly string  $auteurs,
        public readonly ?string $isbn,
        public readonly ?string $editeur,
        public readonly string  $langue,
        public readonly ?int    $anneePublication,
        public readonly ?string $description,
        public readonly ?string $imageCouverture,
        public readonly ?int    $nombrePages,
        public readonly ?string $format,
        public readonly bool    $actif,
        public readonly array   $categories,
        public readonly ?int    $categoriePrincipaleId,
        public readonly ?string $slug = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            titre:                 $request->string('titre')->toString(),
            auteurs:               $request->string('auteurs')->toString(),
            isbn:                  $request->input('isbn'),
            editeur:               $request->input('editeur'),
            langue:                $request->input('langue', 'Français'),
            anneePublication:      $request->integer('annee_publication') ?: null,
            description:           $request->input('description'),
            imageCouverture:       $request->input('image_couverture_url') ?: $request->input('image_couverture'),
            nombrePages:           $request->integer('nombre_pages') ?: null,
            format:                $request->input('format'),
            actif:                 $request->boolean('actif', true),
            categories:            (array) $request->input('categories', []),
            categoriePrincipaleId: $request->integer('categorie_principale_id') ?: null,
            slug:                  $request->input('slug'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            titre:                 $data['titre'],
            auteurs:               $data['auteurs'],
            isbn:                  $data['isbn'] ?? null,
            editeur:               $data['editeur'] ?? null,
            langue:                $data['langue'] ?? 'Français',
            anneePublication:      $data['annee_publication'] ?? null,
            description:           $data['description'] ?? null,
            imageCouverture:       $data['image_couverture'] ?? null,
            nombrePages:           $data['nombre_pages'] ?? null,
            format:                $data['format'] ?? null,
            actif:                 $data['actif'] ?? true,
            categories:            $data['categories'] ?? [],
            categoriePrincipaleId: $data['categorie_principale_id'] ?? null,
            slug:                  $data['slug'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'titre'            => $this->titre,
            'auteurs'          => $this->auteurs,
            'isbn'             => $this->isbn,
            'editeur'          => $this->editeur,
            'langue'           => $this->langue,
            'annee_publication'=> $this->anneePublication,
            'description'      => $this->description,
            'image_couverture' => $this->imageCouverture,
            'nombre_pages'     => $this->nombrePages,
            'format'           => $this->format,
            'actif'            => $this->actif,
            'slug'             => $this->slug,
        ], fn ($v) => ! is_null($v));
    }
}
