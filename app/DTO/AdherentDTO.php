<?php

namespace App\DTO;

use App\Models\Adherent;

class AdherentDTO
{
    public function __construct(
        public readonly ?int               $id = null,
        public readonly ?int               $user_id = null,
        public readonly ?string            $num_carte = null,
        public readonly ?int               $type_adherent_id = null,
        public readonly ?string            $nom = null,
        public readonly ?string            $prenom = null,
        public readonly ?string            $email = null,
        public readonly ?string            $telephone = null,
        public readonly ?string            $adresse = null,
        public readonly ?string            $photo = null,
        public readonly ?string            $date_naissance = null,
        public readonly ?string            $date_inscription = null,
        public readonly ?string            $date_expiration = null,
        public readonly ?string            $statut = null,
        public readonly ?string            $motif_radiation = null,
        public readonly ?TypeAdherentDTO   $type_adherent = null,
        public readonly int                $prets_actifs_count = 0,
        public readonly int                $penalites_impayees_count = 0,
    ) {}

    public static function fromModel(Adherent $model): self
    {
        return new self(
            id: $model->id,
            user_id: $model->user_id,
            num_carte: $model->num_carte,
            type_adherent_id: $model->type_adherent_id,
            nom: $model->nom,
            prenom: $model->prenom,
            email: $model->email,
            telephone: $model->telephone,
            adresse: $model->adresse,
            photo: $model->photo,
            date_naissance: $model->date_naissance?->toDateString(),
            date_inscription: $model->date_inscription?->toDateString(),
            date_expiration: $model->date_expiration?->toDateString(),
            statut: $model->statut?->value,
            motif_radiation: $model->motif_radiation,
            type_adherent: $model->relationLoaded('typeAdherent') && $model->typeAdherent
                ? TypeAdherentDTO::fromModel($model->typeAdherent)
                : null,
            // prets_actifs_count: $model->prets_actifs_count ?? 0,
            // penalites_impayees_count: $model->penalites_impayees_count ?? 0,
        );
    }

    public static function fromRequest($request): self
    {
        return new self(
            type_adherent_id: (int) $request->validated('type_adherent_id'),
            nom: $request->validated('nom'),
            prenom: $request->validated('prenom'),
            email: $request->validated('email'),
            telephone: $request->validated('telephone'),
            adresse: $request->validated('adresse'),
            date_naissance: $request->validated('date_naissance'),
            date_inscription: $request->validated('date_inscription', now()->toDateString()),
            statut: $request->validated('statut'),
            motif_radiation: $request->validated('motif_radiation'),
        );
    }

    public function fullName(): string
    {
        return trim(($this->prenom ?? '') . ' ' . ($this->nom ?? ''));
    }

    public function toArray(): array
    {
        return array_filter([
            'type_adherent_id' => $this->type_adherent_id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'adresse' => $this->adresse,
            'date_naissance' => $this->date_naissance,
            'date_inscription' => $this->date_inscription,
            'statut' => $this->statut,
            'motif_radiation' => $this->motif_radiation,
        ], fn ($value) => $value !== null);
    }
}
