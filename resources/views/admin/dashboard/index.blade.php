@extends('layouts.admin')

@section('header')
<div class="flex justify-between items-center w-full">
    <span>Tableau de bord - Bibliothèque</span>
    <form action="{{ route('admin.statistiques.export') }}" method="POST" class="inline">
        @csrf
        <input type="hidden" name="type" value="statistiques">
        <input type="hidden" name="format" value="pdf">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Générer le rapport PDF
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
