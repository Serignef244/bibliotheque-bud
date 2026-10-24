<div class="space-y-6">
    <!-- Ligne 1 : Indicateurs Principaux (KPIs Stratégiques) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Livres -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Ouvrages</span>
                    <p class="text-3xl font-poppins font-extrabold text-slate-900 mt-1">{{ number_format($stats['totalBooks']) }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-blue-50 border border-blue-100 text-secondary flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="inline-flex items-center gap-1 font-semibold px-2 py-0.5 rounded-full {{ $stats['totalBooksEvolution'] >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                    {{ $stats['totalBooksEvolution'] >= 0 ? '↑ +' : '↓ ' }}{{ abs($stats['totalBooksEvolution']) }}%
                </span>
                <span class="text-slate-400">vs mois précédent</span>
            </div>
        </div>

        <!-- Adhérents Actifs -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Adhérents Actifs</span>
                    <p class="text-3xl font-poppins font-extrabold text-slate-900 mt-1">{{ number_format($stats['activeMembers']) }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="inline-flex items-center gap-1 font-semibold px-2 py-0.5 rounded-full {{ $stats['activeMembersEvolution'] >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                    {{ $stats['activeMembersEvolution'] >= 0 ? '↑ +' : '↓ ' }}{{ abs($stats['activeMembersEvolution']) }}%
                </span>
                <span class="text-slate-400">vs mois précédent</span>
            </div>
        </div>

        <!-- Prêts en cours -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Prêts en cours</span>
                    <p class="text-3xl font-poppins font-extrabold text-slate-900 mt-1">{{ number_format($stats['currentLoans']) }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="inline-flex items-center gap-1 font-semibold px-2 py-0.5 rounded-full {{ $stats['currentLoansEvolution'] >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                    {{ $stats['currentLoansEvolution'] >= 0 ? '↑ +' : '↓ ' }}{{ abs($stats['currentLoansEvolution']) }}%
                </span>
                <span class="text-slate-400">vs mois précédent</span>
            </div>
        </div>

        <!-- Pénalités impayées -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pénalités Impayées</span>
                    <p class="text-2xl sm:text-3xl font-poppins font-extrabold text-rose-600 mt-1">{{ number_format($stats['totalFines'], 0, ',', ' ') }} <span class="text-xs font-bold text-slate-500">FCFA</span></p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="inline-flex items-center gap-1 font-semibold px-2 py-0.5 rounded-full {{ $stats['totalFinesEvolution'] <= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                    {{ $stats['totalFinesEvolution'] >= 0 ? '↑ +' : '↓ ' }}{{ abs($stats['totalFinesEvolution']) }}%
                </span>
                <span class="text-slate-400">vs mois précédent</span>
            </div>
        </div>

    </div>
    
    <!-- Ligne 2 : Métriques Opérationnelles & Rotation -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Prêts du mois -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500">📖 Prêts ce mois</span>
                <span class="inline-flex items-center text-[11px] font-semibold px-2 py-0.5 rounded-md {{ $stats['monthlyLoansEvolution'] >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                    {{ $stats['monthlyLoansEvolution'] >= 0 ? '↑ +' : '↓ ' }}{{ abs($stats['monthlyLoansEvolution']) }}%
                </span>
            </div>
            <p class="text-2xl font-poppins font-bold text-slate-900">{{ number_format($stats['monthlyLoans']) }}</p>
            <p class="text-[11px] text-slate-400 mt-2">Volume mensuel de sorties</p>
        </div>

        <!-- Prêts en retard -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500">⏰ Retards actifs</span>
                <span class="inline-flex items-center text-[11px] font-semibold px-2 py-0.5 rounded-md {{ $stats['lateLoans'] > 0 ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-emerald-50 text-emerald-700' }}">
                    {{ $stats['lateLoans'] > 0 ? 'Alerte' : 'Zéro retard' }}
                </span>
            </div>
            <p class="text-2xl font-poppins font-bold {{ $stats['lateLoans'] > 0 ? 'text-rose-600' : 'text-slate-900' }}">
                {{ number_format($stats['lateLoans']) }}
            </p>
            <p class="text-[11px] text-slate-400 mt-2">Nécessitent une relance</p>
        </div>

        <!-- Inscriptions mois -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500">📅 Nouveaux Adhérents</span>
                <span class="inline-flex items-center text-[11px] font-semibold px-2 py-0.5 rounded-md {{ $stats['monthlyRegistrationsEvolution'] >= 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                    {{ $stats['monthlyRegistrationsEvolution'] >= 0 ? '↑ +' : '↓ ' }}{{ abs($stats['monthlyRegistrationsEvolution']) }}%
                </span>
            </div>
            <p class="text-2xl font-poppins font-bold text-slate-900">{{ number_format($stats['monthlyRegistrations']) }}</p>
            <p class="text-[11px] text-slate-400 mt-2">Inscrits ces 30 derniers jours</p>
        </div>

        <!-- Fréquentation / Taux de rotation -->
        <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500">📈 Taux de Rotation</span>
                <span class="text-[11px] font-semibold text-primary bg-blue-50 px-2 py-0.5 rounded-md">Emprunts</span>
            </div>
            <p class="text-2xl font-poppins font-bold text-slate-900">{{ $stats['frequentationRate'] }}%</p>
            <p class="text-[11px] text-slate-400 mt-2">Part du catalogue en circulation</p>
        </div>

    </div>
</div>
