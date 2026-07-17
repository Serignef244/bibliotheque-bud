<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Prêts récents -->
    <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">📖 Prêts récents</h3>
            <a href="{{ route('admin.prets.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Voir tout</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 bg-slate-50 uppercase">
                    <tr>
                        <th class="px-6 py-3">Adhérent</th>
                        <th class="px-6 py-3">Ouvrage</th>
                        <th class="px-6 py-3">Date emprunt</th>
                        <th class="px-6 py-3">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($recentLoans as $pret)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $pret->adherent?->nom ?? 'Inconnu' }} {{ $pret->adherent?->prenom }}</td>
                        <td class="px-6 py-4">{{ $pret->exemplaire->ouvrage->titre }}</td>
                        <td class="px-6 py-4">{{ $pret->date_emprunt->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @if($pret->statut === 'en_cours')
                                <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-xl text-xs font-medium">En cours</span>
                            @elseif($pret->statut === 'retard')
                                <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded-xl text-xs font-medium">En retard ⚠️</span>
                            @elseif($pret->statut === 'retourne')
                                <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-xl text-xs font-medium">Rendu ✅</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-slate-500">Aucun prêt récent</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Retards -->
    <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">⏰ Prêts en retard</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 bg-slate-50 uppercase">
                    <tr>
                        <th class="px-6 py-3">Adhérent</th>
                        <th class="px-6 py-3">Ouvrage</th>
                        <th class="px-6 py-3">Retard</th>
                        <th class="px-6 py-3">Pénalité est.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($lateLoans as $pret)
                    @php
                        $joursRetard = now()->diffInDays($pret->date_retour_prevue, false);
                        $joursRetard = $joursRetard < 0 ? abs(intval($joursRetard)) : 0;
                        $penaliteEstimee = $joursRetard * 100; // Exemple: 100 FCFA / jour
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $pret->adherent?->nom ?? 'Inconnu' }} {{ $pret->adherent?->prenom }}</td>
                        <td class="px-6 py-4">{{ $pret->exemplaire->ouvrage->titre }}</td>
                        <td class="px-6 py-4 text-red-600 font-medium">{{ $joursRetard }} jours</td>
                        <td class="px-6 py-4 font-bold">{{ $penaliteEstimee }} FCFA</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-slate-500">Aucun retard</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Derniers adhérents inscrits -->
    <div class="rounded-xl bg-white shadow-sm border border-slate-200 overflow-hidden lg:col-span-2">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">👥 Derniers adhérents inscrits</h3>
            <a href="{{ route('admin.adherents.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Voir tout</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 bg-slate-50 uppercase">
                    <tr>
                        <th class="px-6 py-3">Nom</th>
                        <th class="px-6 py-3">Prénom</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Date d'inscription</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($recentMembers as $adherent)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $adherent->nom }}</td>
                        <td class="px-6 py-4">{{ $adherent->prenom }}</td>
                        <td class="px-6 py-4">{{ $adherent->typeAdherent ? $adherent->typeAdherent->nom : 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $adherent->date_inscription->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-slate-500">Aucun adhérent récent</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
