<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Chart 1: Évolution des prêts -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-poppins font-bold text-base sm:text-lg text-slate-900">Évolution des Prêts</h3>
                <p class="text-xs text-slate-500">Flux mensuel des sorties d'ouvrages sur 12 mois</p>
            </div>
            <span class="text-xs font-semibold text-primary bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-lg">Mensuel</span>
        </div>
        <div class="h-72">
            <canvas id="loansChart"></canvas>
        </div>
    </div>

    <!-- Chart 2: Top 5 ouvrages -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-poppins font-bold text-base sm:text-lg text-slate-900">Top 5 des Ouvrages</h3>
                <p class="text-xs text-slate-500">Titres les plus plébiscités par les adhérents</p>
            </div>
            <span class="text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-lg">Populaire</span>
        </div>
        <div class="h-72">
            <canvas id="topBooksChart"></canvas>
        </div>
    </div>

    <!-- Chart 3: Répartition adhérents -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-poppins font-bold text-base sm:text-lg text-slate-900">Répartition des Adhérents</h3>
                <p class="text-xs text-slate-500">Distribution par catégorie (Étudiants, Enseignants...)</p>
            </div>
            <span class="text-xs font-semibold text-indigo-700 bg-indigo-50 border border-indigo-200 px-2.5 py-1 rounded-lg">Membres</span>
        </div>
        <div class="h-72 flex justify-center items-center">
            <canvas id="membersChart"></canvas>
        </div>
    </div>

    <!-- Chart 4: Pénalités -->
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-poppins font-bold text-base sm:text-lg text-slate-900">Pénalités Encaissées</h3>
                <p class="text-xs text-slate-500">Montants recouvrés par mois (en FCFA)</p>
            </div>
            <span class="text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-lg">Finances</span>
        </div>
        <div class="h-72">
            <canvas id="finesChart"></canvas>
        </div>
    </div>
</div>
