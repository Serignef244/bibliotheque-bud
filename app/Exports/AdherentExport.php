<?php

namespace App\Exports;

use App\Models\Adherent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdherentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $period;

    public function __construct($period = null)
    {
        $this->period = $period;
    }

    public function collection()
    {
        $query = Adherent::with('typeAdherent');
        
        if ($this->period && isset($this->period['start']) && isset($this->period['end'])) {
            $query->whereBetween('date_inscription', [$this->period['start'], $this->period['end']]);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'N° Carte',
            'Nom',
            'Prénom',
            'Email',
            'Téléphone',
            'Type',
            'Statut',
            'Date Inscription',
            'Date Expiration'
        ];
    }

    public function map($adherent): array
    {
        return [
            $adherent->num_carte,
            $adherent->nom,
            $adherent->prenom,
            $adherent->email,
            $adherent->telephone,
            $adherent->typeAdherent ? $adherent->typeAdherent->nom : '',
            $adherent->statut,
            $adherent->date_inscription->format('d/m/Y'),
            $adherent->date_expiration ? $adherent->date_expiration->format('d/m/Y') : ''
        ];
    }
}
