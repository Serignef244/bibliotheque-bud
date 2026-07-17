<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function index()
    {
        return view('admin.exports.index');
    }

    public function export(Request $request)
    {
        $request->validate([
            'type' => 'required|in:ouvrages,adherents,prets,penalites,statistiques',
            'format' => 'required|in:excel,csv,pdf',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);
        
        $period = null;
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $period = [
                'start' => $request->date_debut,
                'end' => $request->date_fin
            ];
        }

        return $this->exportService->export(
            $request->input('type'), 
            $request->input('format'),
            $period
        );
    }
}
