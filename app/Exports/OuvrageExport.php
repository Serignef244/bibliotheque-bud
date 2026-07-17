<?php

namespace App\Exports;

use App\Models\Ouvrage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OuvrageExport implements FromCollection, WithHeadings, WithMapping
{
    protected $period;

    public function __construct($period = null)
    {
        $this->period = $period;
    }

    public function collection()
    {
        $query = Ouvrage::with(['categories', 'exemplaires']);
        
        if ($this->period && isset($this->period['start']) && isset($this->period['end'])) {
            $query->whereBetween('created_at', [$this->period['start'], $this->period['end']]);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Titre',
            'Auteur',
            'ISBN',
            'Éditeur',
            'Année',
            'Catégories',
            'Total Exemplaires',
            'Disponibles',
            'Date d\'ajout'
        ];
    }

    public function map($ouvrage): array
    {
        $totalExemplaires = $ouvrage->exemplaires->count();
        $disponibles = $ouvrage->exemplaires->where('est_disponible', true)->count();
        
        return [
            $ouvrage->id,
            $ouvrage->titre,
            $ouvrage->auteur,
            $ouvrage->isbn,
            $ouvrage->editeur,
            $ouvrage->annee_publication,
            $ouvrage->categories->pluck('nom')->join(', '),
            $totalExemplaires,
            $disponibles,
            $ouvrage->created_at->format('d/m/Y')
        ];
    }
}
