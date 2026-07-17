<?php

namespace App\Exports;

use App\Models\Penalite;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenaliteExport implements FromCollection, WithHeadings, WithMapping
{
    protected $period;

    public function __construct($period = null)
    {
        $this->period = $period;
    }

    public function collection()
    {
        $query = Penalite::with(['adherent', 'pret.exemplaire.ouvrage']);
        
        if ($this->period && isset($this->period['start']) && isset($this->period['end'])) {
            $query->whereBetween('created_at', [$this->period['start'], $this->period['end']]);
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
            'Motif',
            'Montant Initial',
            'Montant Restant',
            'Date Création',
            'Statut'
        ];
    }

    public function map($penalite): array
    {
        $ouvrage = $penalite->pret && $penalite->pret->exemplaire && $penalite->pret->exemplaire->ouvrage 
            ? $penalite->pret->exemplaire->ouvrage->titre 
            : 'N/A';
            
        return [
            $penalite->id,
            $penalite->adherent->nom . ' ' . $penalite->adherent->prenom,
            $penalite->adherent->num_carte,
            $ouvrage,
            $penalite->motif,
            $penalite->montant,
            $penalite->montant_restant,
            $penalite->created_at->format('d/m/Y'),
            $penalite->statut
        ];
    }
}
