<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Ligne 1 -->
    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-slate-500">📚 Total livres</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($stats['totalBooks']) }}</p>
            </div>
            <div class="h-10 w-10 rounded bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="{{ $stats['totalBooksEvolution'] >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium flex items-center">
                {{ $stats['totalBooksEvolution'] >= 0 ? '↑' : '↓' }} {{ abs($stats['totalBooksEvolution']) }}%
            </span>
            <span class="text-slate-500 ml-2">vs mois précédent</span>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-slate-500">👥 Adhérents actifs</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($stats['activeMembers']) }}</p>
            </div>
            <div class="h-10 w-10 rounded bg-green-50 text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="{{ $stats['activeMembersEvolution'] >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium flex items-center">
                {{ $stats['activeMembersEvolution'] >= 0 ? '↑' : '↓' }} {{ abs($stats['activeMembersEvolution']) }}%
            </span>
            <span class="text-slate-500 ml-2">vs mois précédent</span>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-slate-500">🔄 Prêts en cours</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($stats['currentLoans']) }}</p>
            </div>
            <div class="h-10 w-10 rounded bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="{{ $stats['currentLoansEvolution'] >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium flex items-center">
                {{ $stats['currentLoansEvolution'] >= 0 ? '↑' : '↓' }} {{ abs($stats['currentLoansEvolution']) }}%
            </span>
            <span class="text-slate-500 ml-2">vs mois précédent</span>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-slate-500">💰 Pénalités impayées</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($stats['totalFines'], 0, ',', ' ') }} FCFA</p>
            </div>
            <div class="h-10 w-10 rounded bg-red-50 text-red-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="{{ $stats['totalFinesEvolution'] <= 0 ? 'text-green-600' : 'text-red-600' }} font-medium flex items-center">
                {{ $stats['totalFinesEvolution'] >= 0 ? '↑' : '↓' }} {{ abs($stats['totalFinesEvolution']) }}%
            </span>
            <span class="text-slate-500 ml-2">vs mois précédent</span>
        </div>
    </div>
    
    <!-- Ligne 2 -->
    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-slate-500">📖 Prêts du mois</p>
                <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($stats['monthlyLoans']) }}</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="{{ $stats['monthlyLoansEvolution'] >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium flex items-center">
                {{ $stats['monthlyLoansEvolution'] >= 0 ? '↑' : '↓' }} {{ abs($stats['monthlyLoansEvolution']) }}%
            </span>
            <span class="text-slate-500 ml-2">vs mois précédent</span>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-slate-500">⏰ Prêts en retard</p>
                <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($stats['lateLoans']) }}</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="{{ $stats['lateLoansEvolution'] <= 0 ? 'text-green-600' : 'text-red-600' }} font-medium flex items-center">
                {{ $stats['lateLoansEvolution'] >= 0 ? '↑' : '↓' }} {{ abs($stats['lateLoansEvolution']) }}%
            </span>
            <span class="text-slate-500 ml-2">vs mois précédent</span>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-slate-500">📅 Inscriptions mois</p>
                <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($stats['monthlyRegistrations']) }}</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="{{ $stats['monthlyRegistrationsEvolution'] >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium flex items-center">
                {{ $stats['monthlyRegistrationsEvolution'] >= 0 ? '↑' : '↓' }} {{ abs($stats['monthlyRegistrationsEvolution']) }}%
            </span>
            <span class="text-slate-500 ml-2">vs mois précédent</span>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-slate-500">📈 Fréquentation</p>
                <p class="text-2xl font-bold text-slate-900 mt-2">{{ $stats['frequentationRate'] }}%</p>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-slate-500">Taux global de prêts</span>
        </div>
    </div>
</div>
