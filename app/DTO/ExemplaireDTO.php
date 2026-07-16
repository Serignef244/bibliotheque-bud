<?php

namespace App\DTO;

use App\Enums\StatutExemplaire;
use Illuminate\Http\Request;

final class ExemplaireDTO
{
    public function __construct(
        public readonly int    $ouvrageId,
        public readonly string $codeBarre,
        public readonly ?string $cote,
        public readonly StatutExemplaire $statut,
        public readonly ?string $dateAcquisition,
        public readonly ?float  $prixAcquisition,
        public readonly ?string $fournisseur,
        public readonly ?string $notes,
        public readonly int     $etat,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            ouvrageId:       $request->integer('ouvrage_id'),
            codeBarre:       $request->string('code_barre')->toString(),
            cote:            $request->input('cote'),
            statut:          StatutExemplaire::from($request->input('statut', StatutExemplaire::DISPONIBLE->value)),
            dateAcquisition: $request->input('date_acquisition'),
            prixAcquisition: $request->input('prix_acquisition') ? (float) $request->input('prix_acquisition') : null,
            fournisseur:     $request->input('fournisseur'),
            notes:           $request->input('notes'),
            etat:            $request->integer('etat', 5),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            ouvrageId:       $data['ouvrage_id'],
            codeBarre:       $data['code_barre'],
            cote:            $data['cote'] ?? null,
            statut:          StatutExemplaire::from($data['statut'] ?? StatutExemplaire::DISPONIBLE->value),
            dateAcquisition: $data['date_acquisition'] ?? null,
            prixAcquisition: $data['prix_acquisition'] ?? null,
            fournisseur:     $data['fournisseur'] ?? null,
            notes:           $data['notes'] ?? null,
            etat:            $data['etat'] ?? 5,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'ouvrage_id'       => $this->ouvrageId,
            'code_barre'       => $this->codeBarre,
            'cote'             => $this->cote,
            'statut'           => $this->statut->value,
            'date_acquisition' => $this->dateAcquisition,
            'prix_acquisition' => $this->prixAcquisition,
            'fournisseur'      => $this->fournisseur,
            'notes'            => $this->notes,
            'etat'             => $this->etat,
        ], fn ($v) => ! is_null($v));
    }
}
