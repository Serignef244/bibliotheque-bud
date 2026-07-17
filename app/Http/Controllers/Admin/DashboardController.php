<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatistiqueService;
use App\Models\Pret;
use App\Models\Adherent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected $statService;

    public function __construct(StatistiqueService $statService)
    {
        $this->statService = $statService;
    }

    public function index(): View
    {
        $stats = $this->statService->getStats();
        
        $recentLoans = Pret::with(['adherent', 'exemplaire.ouvrage'])
                           ->latest()
                           ->take(5)
                           ->get();
                           
        $lateLoans = Pret::with(['adherent', 'exemplaire.ouvrage'])
                         ->where('statut', 'retard')
                         ->take(5)
                         ->get();
                         
        $recentMembers = Adherent::with('typeAdherent')
                                 ->latest('date_inscription')
                                 ->take(5)
                                 ->get();

        return view('admin.dashboard.index', compact('stats', 'recentLoans', 'lateLoans', 'recentMembers'));
    }
    
    public function chartData(Request $request)
    {
        $type = $request->input('type');
        $period = $request->input('period', 'year');
        
        $data = $this->statService->getChartData($type, $period);
        
        return response()->json($data);
    }
}
