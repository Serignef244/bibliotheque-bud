<div class="space-y-6">
    {{-- Résumé / Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total impayé</p>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($statistiques['total_impaye'], 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Pénalités ce mois</p>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($statistiques['ce_mois'], 0, ',', ' ') }} FCFA</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Adhérents bloqués</p>
                <p class="text-2xl font-bold text-slate-900">{{ $statistiques['adherents_bloques'] }}</p>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Recherche</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="recherche"
                           placeholder="Nom, prénom, n° de carte..."
                           class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Statut</label>
                <select wire:model.live="statut"
                        class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    <option value="">Tous les statuts</option>
                    @foreach($statuts as $s)
                        <option value="{{ $s['value'] }}">{{ $s['label'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Loading --}}
    <div wire:loading class="flex justify-center py-8">
        <div class="flex items-center gap-3 text-indigo-600">
            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium">Chargement...</span>
        </div>
    </div>

    {{-- Résultats --}}
    <div wire:loading.remove class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <p class="text-sm text-slate-500">
                <span class="font-semibold text-slate-700">{{ $penalites->total() }}</span> pénalité(s)
            </p>
        </div>

        @if($penalites->isEmpty())
            <div class="py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-slate-700 font-medium">Aucune pénalité trouvée</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">ID</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Adhérent</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Montant Total</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Reste à payer</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide">Statut</th>
                            <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wide text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($penalites as $penalite)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">#{{ $penalite->id }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">{{ $penalite->adherent->prenom }} {{ $penalite->adherent->nom }}</div>
                                <div class="text-xs text-slate-500">{{ $penalite->adherent->num_carte }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $penalite->montant_formate }}</td>
                            <td class="px-6 py-4 text-sm font-medium {{ $penalite->montant_restant > 0 ? 'text-red-600' : 'text-slate-500' }}">
                                {{ $penalite->restant_formate }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-0.5 rounded-xl text-xs font-medium {{ $penalite->statut->color() }}">
                                    {{ $penalite->statut->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($penalite->isUnpaid() || $penalite->statut === \App\Enums\StatutPenalite::PARTIEL)
                                    <a href="{{ route('admin.penalites.show', $penalite) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Payer
                                    </a>
                                @else
                                    <a href="{{ route('admin.penalites.show', $penalite) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">
                                        Voir
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($penalites->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                    {{ $penalites->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
