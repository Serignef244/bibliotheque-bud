@extends('layouts.admin')

@section('header')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 w-full">
    <div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold uppercase tracking-wider text-primary bg-blue-50 border border-blue-100 px-2.5 py-0.5 rounded-md">
                {{ auth()->user()->hasRole('admin') ? '👑 Direction (Super Admin)' : '📚 Espace Bibliothécaire' }}
            </span>
            <span class="text-xs text-slate-400">• Pilotage en temps réel</span>
        </div>
        <h1 class="text-lg sm:text-xl font-poppins font-bold text-slate-900 mt-1">Tableau de Bord Analytique</h1>
    </div>

    <form action="{{ route('admin.statistiques.export') }}" method="POST" class="inline">
        @csrf
        <input type="hidden" name="type" value="statistiques">
        <input type="hidden" name="format" value="pdf">
        <button type="submit" class="bg-primary hover:bg-blue-900 text-white px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold shadow-sm hover:shadow hover:-translate-y-0.5 active:scale-[0.98] transition-all flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <span>Exporter le Rapport PDF</span>
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="space-y-8">
    @include('admin.dashboard.widgets')
    @include('admin.dashboard.charts')
    @include('admin.dashboard.tables')
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fetchChartData = async (type) => {
            const response = await fetch(`/admin/dashboard/chart-data?type=${type}`);
            return await response.json();
        };

        const initCharts = async () => {
            // Chart 1: Évolution des prêts
            const loansData = await fetchChartData('loans_evolution');
            new Chart(document.getElementById('loansChart'), {
                type: 'bar',
                data: loansData,
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Chart 2: Top 5 ouvrages
            const topBooksData = await fetchChartData('top_books');
            new Chart(document.getElementById('topBooksChart'), {
                type: 'bar',
                data: topBooksData,
                options: { 
                    indexAxis: 'y',
                    responsive: true, 
                    maintainAspectRatio: false 
                }
            });

            // Chart 3: Répartition adhérents
            const membersData = await fetchChartData('members_type');
            new Chart(document.getElementById('membersChart'), {
                type: 'doughnut',
                data: membersData,
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Chart 4: Pénalités par mois
            const finesData = await fetchChartData('fines_evolution');
            new Chart(document.getElementById('finesChart'), {
                type: 'line',
                data: finesData,
                options: { responsive: true, maintainAspectRatio: false, fill: true }
            });
        };

        initCharts();
    });
</script>
@endpush
