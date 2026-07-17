<?php

namespace App\Exports;

use App\Models\Pret;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PretExport implements FromCollection, WithHeadings, WithMapping
{
    protected $period;

    public function __construct($period = null)
    {
        $this->period = $period;
    }

    public function collection()
    {
        $query = Pret::with(['adherent', 'exemplaire.ouvrage']);
        
        if ($this->period && isset($this->period['start']) && isset($this->period['end'])) {
            $query->whereBetween('date_emprunt', [$this->period['start'], $this->period['end']]);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Adhérent',
            'N° Carte',
            'Ouvrage',
            'Code-barres',
            'Date Emprunt',
            'Date Retour Prévue',
            'Date Retour Réelle',
            'Statut'
        ];
    }

    public function map($pret): array
    {
        return [
            $pret->id,
            $pret->adherent->nom . ' ' . $pret->adherent->prenom,
            $pret->adherent->num_carte,
            $pret->exemplaire->ouvrage->titre,
            $pret->exemplaire->code_barres,
            $pret->date_emprunt->format('d/m/Y'),
            $pret->date_retour_prevue->format('d/m/Y'),
            $pret->date_retour_reelle ? $pret->date_retour_reelle->format('d/m/Y') : '',
            $pret->statut
        ];
    }
}
