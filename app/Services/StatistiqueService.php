<?php

namespace App\Services;

use App\Models\Adherent;
use App\Models\Ouvrage;
use App\Models\Penalite;
use App\Models\Pret;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatistiqueService
{
    /**
     * Get all statistics for the dashboard
     */
    public function getStats(): array
    {
        return [
            'totalBooks' => Ouvrage::count(),
            'totalBooksEvolution' => $this->getEvolution(Ouvrage::class),
            'activeMembers' => Adherent::where('statut', 'actif')->count(),
            'activeMembersEvolution' => $this->getEvolution(Adherent::class, function($query) {
                return $query->where('statut', 'actif');
            }),
            'currentLoans' => Pret::whereIn('statut', ['en_cours', 'retard'])->count(),
            'currentLoansEvolution' => $this->getEvolution(Pret::class, function($query) {
                return $query->whereIn('statut', ['en_cours', 'retard']);
            }),
            'totalFines' => Penalite::where('statut', 'impaye')->sum('montant_restant'),
            'totalFinesEvolution' => $this->getEvolution(Penalite::class, function($query) {
                return $query->where('statut', 'impaye');
            }, 'montant_restant', true),
            'monthlyLoans' => Pret::whereMonth('date_emprunt', now()->month)
                                  ->whereYear('date_emprunt', now()->year)->count(),
            'monthlyLoansEvolution' => $this->getMonthlyEvolution(Pret::class, 'date_emprunt'),
            'lateLoans' => Pret::where('statut', 'retard')->count(),
            'lateLoansEvolution' => $this->getEvolution(Pret::class, function($query) {
                return $query->where('statut', 'retard');
            }),
            'monthlyRegistrations' => Adherent::whereMonth('date_inscription', now()->month)
                                              ->whereYear('date_inscription', now()->year)->count(),
            'monthlyRegistrationsEvolution' => $this->getMonthlyEvolution(Adherent::class, 'date_inscription'),
            'frequentationRate' => $this->getFrequentationRate(),
            'frequentationRateEvolution' => 0, // Placeholder as calculation is complex
        ];
    }
    
    private function getEvolution($modelClass, $callback = null, $column = 'id', $isSum = false): int
    {
        // Simple comparison between this month and last month
        $startOfThisMonth = now()->startOfMonth();
        
        $queryThisMonth = $modelClass::where('created_at', '>=', $startOfThisMonth);
        $queryLastMonth = $modelClass::where('created_at', '>=', now()->subMonth()->startOfMonth())
                                     ->where('created_at', '<', $startOfThisMonth);
                                     
        if ($callback) {
            $queryThisMonth = $callback($queryThisMonth);
            $queryLastMonth = $callback($queryLastMonth);
        }
        
        $valThisMonth = $isSum ? $queryThisMonth->sum($column) : $queryThisMonth->count();
        $valLastMonth = $isSum ? $queryLastMonth->sum($column) : $queryLastMonth->count();
        
        if ($valLastMonth == 0) return $valThisMonth > 0 ? 100 : 0;
        
        return (int) round((($valThisMonth - $valLastMonth) / $valLastMonth) * 100);
    }
    
    private function getMonthlyEvolution($modelClass, $dateColumn): int
    {
        $startOfThisMonth = now()->startOfMonth();
        
        $valThisMonth = $modelClass::where($dateColumn, '>=', $startOfThisMonth)->count();
        $valLastMonth = $modelClass::where($dateColumn, '>=', now()->subMonth()->startOfMonth())
                                   ->where($dateColumn, '<', $startOfThisMonth)->count();
                                   
        if ($valLastMonth == 0) return $valThisMonth > 0 ? 100 : 0;
        
        return (int) round((($valThisMonth - $valLastMonth) / $valLastMonth) * 100);
    }
    
    private function getFrequentationRate(): int
    {
        $activeMembersCount = Adherent::where('statut', 'actif')->count();
        if ($activeMembersCount === 0) return 0;
        
        // Members who borrowed something in the last 30 days
        $activeBorrowers = Pret::where('date_emprunt', '>=', now()->subDays(30))
                               ->distinct('adherent_id')
                               ->count('adherent_id');
                               
        return (int) round(($activeBorrowers / $activeMembersCount) * 100);
    }
    
    /**
     * Get chart data based on type
     */
    public function getChartData(string $type, string $period = 'year'): array
    {
        return match ($type) {
            'loans_evolution' => $this->getLoansEvolutionData(),
            'top_books' => $this->getTopBooksData(),
            'members_type' => $this->getMembersTypeData(),
            'fines_evolution' => $this->getFinesEvolutionData(),
            default => ['labels' => [], 'datasets' => []],
        };
    }
    
    private function getLoansEvolutionData(): array
    {
        $months = collect(range(11, 0))->map(function($i) {
            return now()->subMonths($i)->format('m-Y');
        });
        
        $labels = [];
        $data = [];
        
        foreach ($months as $monthYear) {
            [$m, $y] = explode('-', $monthYear);
            $labels[] = Carbon::createFromDate($y, $m, 1)->translatedFormat('M Y');
            $data[] = Pret::whereMonth('date_emprunt', $m)->whereYear('date_emprunt', $y)->count();
        }
        
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Prêts',
                    'data' => $data,
                    'backgroundColor' => '#3B82F6',
                    'borderRadius' => 4,
                ]
            ]
        ];
    }
    
    private function getTopBooksData(): array
    {
        $topBooks = DB::table('prets')
            ->join('exemplaires', 'prets.exemplaire_id', '=', 'exemplaires.id')
            ->join('ouvrages', 'exemplaires.ouvrage_id', '=', 'ouvrages.id')
            ->select('ouvrages.titre', DB::raw('count(prets.id) as count'))
            ->groupBy('ouvrages.id', 'ouvrages.titre')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
            
        return [
            'labels' => $topBooks->pluck('titre')->toArray(),
            'datasets' => [
                [
                    'label' => 'Emprunts',
                    'data' => $topBooks->pluck('count')->toArray(),
                    'backgroundColor' => '#1E3A8A',
                    'borderRadius' => 4,
                ]
            ]
        ];
    }
    
    private function getMembersTypeData(): array
    {
        $types = DB::table('adherents')
            ->join('types_adherents', 'adherents.type_adherent_id', '=', 'types_adherents.id')
            ->select('types_adherents.nom', DB::raw('count(adherents.id) as count'))
            ->groupBy('types_adherents.id', 'types_adherents.nom')
            ->get();
            
        $colors = ['#1E3A8A', '#3B82F6', '#22C55E', '#F59E0B', '#DBEAFE'];
        
        return [
            'labels' => $types->pluck('nom')->toArray(),
            'datasets' => [
                [
                    'data' => $types->pluck('count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $types->count()),
                ]
            ]
        ];
    }
    
    private function getFinesEvolutionData(): array
    {
        $months = collect(range(11, 0))->map(function($i) {
            return now()->subMonths($i)->format('m-Y');
        });
        
        $labels = [];
        $data = [];
        
        foreach ($months as $monthYear) {
            [$m, $y] = explode('-', $monthYear);
            $labels[] = Carbon::createFromDate($y, $m, 1)->translatedFormat('M Y');
            $data[] = Penalite::whereMonth('created_at', $m)->whereYear('created_at', $y)->sum('montant');
        }
        
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pénalités (FCFA)',
                    'data' => $data,
                    'backgroundColor' => '#EF4444',
                    'borderRadius' => 4,
                ]
            ]
        ];
    }
}
