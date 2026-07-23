<div>
    <div class="mb-4 flex flex-col sm:flex-row gap-4">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="recherche" class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Rechercher un prêt...">
        </div>
        <div class="flex gap-2">
            <select wire:model.live="statut" class="px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm flex-1 sm:flex-none">
                <option value="">Tous les statuts</option>
                <option value="en_cours">En cours</option>
                <option value="rendu">Rendu</option>
                <option value="retard">En retard</option>
            </select>
            <a href="{{ route('admin.prets.create') }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition whitespace-nowrap text-sm font-semibold">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span class="hidden sm:inline">Nouveau prêt</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200 block lg:table w-full">
            <thead class="bg-slate-50 hidden lg:table-header-group">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Adhérent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Ouvrage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date emprunt</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Retour prévu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white lg:divide-y divide-slate-200 block lg:table-row-group p-4 lg:p-0 space-y-4 lg:space-y-0">
                @forelse($prets as $pret)
                <tr class="block lg:table-row hover:bg-slate-50 border border-slate-200 rounded-xl lg:border-none lg:rounded-none overflow-hidden">
                    <td class="px-4 py-3 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-slate-900 flex justify-between items-center lg:table-cell border-b border-slate-100 lg:border-none bg-slate-50 lg:bg-transparent">
                        <span class="font-medium text-slate-500 lg:hidden text-xs uppercase">ID</span>
                        <span class="font-semibold text-indigo-600">#{{ $pret->id }}</span>
                    </td>
                    <td class="px-4 py-3 lg:px-6 lg:py-4 whitespace-nowrap flex justify-between items-center lg:table-cell border-b border-slate-100 lg:border-none">
                        <span class="font-medium text-slate-500 lg:hidden text-xs uppercase">Adhérent</span>
                        <div class="text-right lg:text-left">
                            <div class="text-sm font-medium text-slate-900">{{ $pret->adherent->nom }} {{ $pret->adherent->prenom }}</div>
                            <div class="text-xs text-slate-500">{{ $pret->adherent->num_carte }}</div>
                        </div>
                    </td>
                    <td class="px-4 py-3 lg:px-6 lg:py-4 flex justify-between items-center lg:table-cell border-b border-slate-100 lg:border-none">
                        <span class="font-medium text-slate-500 lg:hidden text-xs uppercase">Ouvrage</span>
                        <div class="text-right lg:text-left max-w-[200px] lg:max-w-none">
                            <div class="text-sm font-medium text-slate-900 truncate">{{ $pret->exemplaire->ouvrage->titre }}</div>
                            <div class="text-xs text-slate-500">{{ $pret->exemplaire->code_barre }}</div>
                        </div>
                    </td>
                    <td class="px-4 py-3 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-slate-900 flex justify-between items-center lg:table-cell border-b border-slate-100 lg:border-none">
                        <span class="font-medium text-slate-500 lg:hidden text-xs uppercase">Emprunt</span>
                        <span>{{ $pret->date_emprunt->format('d/m/Y') }}</span>
                    </td>
                    <td class="px-4 py-3 lg:px-6 lg:py-4 whitespace-nowrap text-sm text-slate-900 flex justify-between items-center lg:table-cell border-b border-slate-100 lg:border-none">
                        <span class="font-medium text-slate-500 lg:hidden text-xs uppercase">Retour</span>
                        <span>{{ $pret->date_retour_prevue->format('d/m/Y') }}</span>
                    </td>
                    <td class="px-4 py-3 lg:px-6 lg:py-4 whitespace-nowrap flex justify-between items-center lg:table-cell border-b border-slate-100 lg:border-none">
                        <span class="font-medium text-slate-500 lg:hidden text-xs uppercase">Statut</span>
                        @if($pret->statut === 'en_cours')
                            <span class="px-2 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-xl">En cours</span>
                        @elseif($pret->statut === 'rendu')
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-xl">Rendu</span>
                        @elseif($pret->statut === 'retard')
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-xl">En retard</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 lg:px-6 lg:py-4 whitespace-nowrap text-sm font-medium flex justify-end items-center lg:table-cell bg-slate-50 lg:bg-transparent">
                        <a href="{{ route('admin.prets.show', $pret->id) }}" class="inline-flex items-center justify-center p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="block lg:table-row">
                    <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500 block lg:table-cell">Aucun prêt trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $prets->links() }}
    </div>
</div>
