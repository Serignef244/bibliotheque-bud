<?php

namespace App\DTO;

use App\Models\Pret;
use Carbon\Carbon;

class PretDTO
{
    public function __construct(
        public ?int $id = null,
        public ?int $adherent_id = null,
        public ?int $exemplaire_id = null,
        public ?Carbon $date_emprunt = null,
        public ?Carbon $date_retour_prevue = null,
        public ?Carbon $date_retour_reelle = null,
        public bool $prolonge = false,
        public string $statut = 'en_cours',
        public ?string $remarques = null,
        public ?string $adherent_nom = null,
        public ?string $adherent_prenom = null,
        public ?string $adherent_num_carte = null,
        public ?string $exemplaire_code_barre = null,
        public ?string $ouvrage_titre = null,
        public ?string $ouvrage_auteur = null,
        public int $jours_retard = 0,
        public ?int $penalite_montant = null,
    ) {}

    public static function fromModel(Pret $pret): self
    {
        return new self(
            id: $pret->id,
            adherent_id: $pret->adherent_id,
            exemplaire_id: $pret->exemplaire_id,
            date_emprunt: $pret->date_emprunt,
            date_retour_prevue: $pret->date_retour_prevue,
            date_retour_reelle: $pret->date_retour_reelle,
            prolonge: (bool) $pret->prolonge,
            statut: $pret->statut,
            remarques: $pret->remarques,
            adherent_nom: $pret->adherent->nom ?? null,
            adherent_prenom: $pret->adherent->prenom ?? null,
            adherent_num_carte: $pret->adherent->num_carte ?? null,
            exemplaire_code_barre: $pret->exemplaire->code_barre ?? null,
            ouvrage_titre: $pret->exemplaire->ouvrage->titre ?? null,
            ouvrage_auteur: $pret->exemplaire->ouvrage->auteurs ?? null,
            jours_retard: $pret->joursDeRetard(),
            penalite_montant: $pret->penalite?->montant ?? null,
        );
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            adherent_id: $data['adherent_id'] ?? null,
            exemplaire_id: $data['exemplaire_id'] ?? null,
            date_emprunt: isset($data['date_emprunt']) ? Carbon::parse($data['date_emprunt']) : now(),
            date_retour_prevue: isset($data['date_retour_prevue']) ? Carbon::parse($data['date_retour_prevue']) : null,
            prolonge: $data['prolonge'] ?? false,
            statut: $data['statut'] ?? 'en_cours',
            remarques: $data['remarques'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'adherent_id' => $this->adherent_id,
            'exemplaire_id' => $this->exemplaire_id,
            'date_emprunt' => $this->date_emprunt?->toDateTimeString(),
            'date_retour_prevue' => $this->date_retour_prevue?->toDateString(),
            'date_retour_reelle' => $this->date_retour_reelle?->toDateString(),
            'prolonge' => $this->prolonge,
            'statut' => $this->statut,
            'remarques' => $this->remarques,
            'adherent_nom' => $this->adherent_nom,
            'adherent_prenom' => $this->adherent_prenom,
            'adherent_num_carte' => $this->adherent_num_carte,
            'exemplaire_code_barre' => $this->exemplaire_code_barre,
            'ouvrage_titre' => $this->ouvrage_titre,
            'ouvrage_auteur' => $this->ouvrage_auteur,
            'jours_retard' => $this->jours_retard,
            'penalite_montant' => $this->penalite_montant,
        ];
    }
}
