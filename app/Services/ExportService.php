<?php

namespace App\Services;

use App\Exports\OuvrageExport;
use App\Exports\AdherentExport;
use App\Exports\PretExport;
use App\Exports\PenaliteExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportService
{
    /**
     * Export data based on type and format
     */
    public function export(string $type, string $format, ?array $period = null)
    {
        return match ($format) {
            'excel' => $this->exportExcel($type, $period),
            'csv' => $this->exportCsv($type, $period),
            'pdf' => $this->exportPdf($type, $period),
            default => abort(400, 'Format non supporté'),
        };
    }
    
    private function exportExcel(string $type, ?array $period)
    {
        $exportClass = $this->getExportClass($type, $period);
        $filename = $type . '_' . now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new $exportClass($period), $filename);
    }
    
    private function exportCsv(string $type, ?array $period)
    {
        $exportClass = $this->getExportClass($type, $period);
        $filename = $type . '_' . now()->format('Y-m-d_His') . '.csv';
        
        return Excel::download(new $exportClass($period), $filename, \Maatwebsite\Excel\Excel::CSV);
    }
    
    private function exportPdf(string $type, ?array $period)
    {
        if ($type === 'statistiques') {
            $stats = app(StatistiqueService::class)->getStats();
            $pdf = Pdf::loadView('pdf.rapport_statistiques', compact('stats', 'period'));
            return $pdf->download('rapport_statistiques_' . now()->format('Y-m-d_His') . '.pdf');
        }
        
        // For other types, we could use DomPDF with a table view, 
        // but for now we'll route them to Excel/CSV as requested in specs.
        // If we strictly need PDF for lists, we can build a generic table PDF view.
        $exportClass = new ($this->getExportClass($type, $period))($period);
        
        $collection = $exportClass->collection();
        $data = [];
        foreach ($collection as $item) {
            $data[] = $exportClass->map($item);
        }
        
        $headings = $exportClass->headings();
        
        $pdf = Pdf::loadView('pdf.generic_table', compact('data', 'headings', 'type', 'period'))
                  ->setPaper('a4', 'landscape');
                  
        return $pdf->download($type . '_' . now()->format('Y-m-d_His') . '.pdf');
    }
    
    private function getExportClass(string $type, ?array $period): string
    {
        return match ($type) {
            'ouvrages' => OuvrageExport::class,
            'adherents' => AdherentExport::class,
            'prets' => PretExport::class,
            'penalites' => PenaliteExport::class,
            default => abort(400, 'Type d\'export non supporté'),
        };
    }
}
