<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Chart 1: Évolution des prêts -->
    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200">
        <h3 class="text-lg font-bold text-slate-900 mb-4">📈 Évolution des prêts (12 derniers mois)</h3>
        <div class="h-72">
            <canvas id="loansChart"></canvas>
        </div>
    </div>

    <!-- Chart 2: Top 5 ouvrages -->
    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200">
        <h3 class="text-lg font-bold text-slate-900 mb-4">🏆 Top 5 des ouvrages les plus empruntés</h3>
        <div class="h-72">
            <canvas id="topBooksChart"></canvas>
        </div>
    </div>

    <!-- Chart 3: Répartition adhérents -->
    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200">
        <h3 class="text-lg font-bold text-slate-900 mb-4">👥 Répartition des adhérents par type</h3>
        <div class="h-72 flex justify-center">
            <canvas id="membersChart"></canvas>
        </div>
    </div>

    <!-- Chart 4: Pénalités -->
    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200">
        <h3 class="text-lg font-bold text-slate-900 mb-4">💰 Pénalités par mois (FCFA)</h3>
        <div class="h-72">
            <canvas id="finesChart"></canvas>
        </div>
    </div>
</div>
