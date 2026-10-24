<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Prêts récents -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-md transition-shadow">
        <div class="p-6 border-b border-slate-200/70 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="font-poppins text-base font-bold text-slate-900">📖 Prêts récents</h3>
                <p class="text-xs text-slate-500 mt-0.5">Dernières sorties enregistrées au comptoir</p>
            </div>
            <a href="{{ route('admin.prets.index') }}" class="text-xs font-semibold text-secondary hover:text-primary transition-colors flex items-center gap-1">
                <span>Voir tout</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs font-semibold text-slate-500 bg-slate-50/80 uppercase tracking-wider border-b border-slate-200/60">
                    <tr>
                        <th class="px-6 py-3.5">Adhérent</th>
                        <th class="px-6 py-3.5">Ouvrage</th>
                        <th class="px-6 py-3.5">Date Emprunt</th>
                        <th class="px-6 py-3.5">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentLoans as $pret)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900">{{ $pret->adherent?->nom ?? 'Inconnu' }} {{ $pret->adherent?->prenom }}</div>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $pret->adherent?->numero_adherent ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-slate-800 line-clamp-1" title="{{ $pret->exemplaire->ouvrage->titre }}">{{ $pret->exemplaire->ouvrage->titre }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">Ex. #{{ $pret->exemplaire->code_barre }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-slate-600">{{ $pret->date_emprunt->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @if($pret->statut === 'en_cours')
                                <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold">En cours</span>
                            @elseif($pret->statut === 'retard')
                                <span class="bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded-full text-xs font-semibold flex items-center gap-1 w-max">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span> Retard
                                </span>
                            @elseif($pret->statut === 'retourne' || $pret->statut === 'rendu')
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-semibold">Rendu ✓</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs">
                            Aucun prêt récent enregistré
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Retards -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-md transition-shadow">
        <div class="p-6 border-b border-slate-200/70 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="font-poppins text-base font-bold text-slate-900">⏰ Alertes Retards Actifs</h3>
                <p class="text-xs text-slate-500 mt-0.5">Emprunts ayant dépassé la date limite</p>
            </div>
            <a href="{{ route('admin.prets.index') }}" class="text-xs font-semibold text-secondary hover:text-primary transition-colors flex items-center gap-1">
                <span>Gérer les retards</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs font-semibold text-slate-500 bg-slate-50/80 uppercase tracking-wider border-b border-slate-200/60">
                    <tr>
                        <th class="px-6 py-3.5">Adhérent</th>
                        <th class="px-6 py-3.5">Ouvrage</th>
                        <th class="px-6 py-3.5">Retard</th>
                        <th class="px-6 py-3.5">Pénalité est.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($lateLoans as $pret)
                    @php
                        $joursRetard = now()->diffInDays($pret->date_retour_prevue, false);
                        $joursRetard = $joursRetard < 0 ? abs(intval($joursRetard)) : 0;
                        $penaliteEstimee = $joursRetard * 100;
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900">{{ $pret->adherent?->nom ?? 'Inconnu' }} {{ $pret->adherent?->prenom }}</div>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $pret->adherent?->telephone ?? 'Sans tél.' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-slate-800 line-clamp-1" title="{{ $pret->exemplaire->ouvrage->titre }}">{{ $pret->exemplaire->ouvrage->titre }}</span>
                            <span class="text-[10px] text-slate-400">Échéance : {{ $pret->date_retour_prevue->format('d/m/Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 font-bold text-xs text-rose-600 bg-rose-50 px-2.5 py-1 rounded-md border border-rose-200">
                                {{ $joursRetard }} jour(s)
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-xs text-slate-900 font-mono">{{ number_format($penaliteEstimee, 0, ',', ' ') }} FCFA</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs">
                            🎉 Aucun retard actif ! Tous les livres sont rendus à temps.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Derniers adhérents inscrits -->
    <div class="rounded-2xl bg-white shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-md transition-shadow lg:col-span-2">
        <div class="p-6 border-b border-slate-200/70 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="font-poppins text-base font-bold text-slate-900">👥 Derniers Adhérents Inscrits</h3>
                <p class="text-xs text-slate-500 mt-0.5">Nouveaux membres enregistrés dans le système</p>
            </div>
            <a href="{{ route('admin.adherents.index') }}" class="text-xs font-semibold text-secondary hover:text-primary transition-colors flex items-center gap-1">
                <span>Tous les adhérents</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs font-semibold text-slate-500 bg-slate-50/80 uppercase tracking-wider border-b border-slate-200/60">
                    <tr>
                        <th class="px-6 py-3.5">Adhérent</th>
                        <th class="px-6 py-3.5">Numéro Carte</th>
                        <th class="px-6 py-3.5">Profil / Type</th>
                        <th class="px-6 py-3.5">Date Inscription</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentMembers as $adherent)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $adherent->nom }} {{ $adherent->prenom }}</div>
                            <span class="text-xs text-slate-400">{{ $adherent->user?->email ?? 'Sans email' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs font-semibold text-slate-700 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                {{ $adherent->numero_adherent ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center text-xs font-medium text-primary bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-full">
                                {{ $adherent->typeAdherent ? $adherent->typeAdherent->nom : 'Standard' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-slate-600">{{ $adherent->date_inscription->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.adherents.show', $adherent->id) }}" class="text-xs font-semibold text-primary hover:text-blue-700 inline-flex items-center gap-1">
                                Fiche &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-xs">
                            Aucun adhérent enregistré récemment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
