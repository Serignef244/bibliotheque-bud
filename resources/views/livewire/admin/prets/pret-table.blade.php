<div>
    <div class="mb-4 flex gap-4">
        <input type="text" wire:model.live="recherche" class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Rechercher...">
        <select wire:model.live="statut" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Tous les statuts</option>
            <option value="en_cours">En cours</option>
            <option value="rendu">Rendu</option>
            <option value="retard">En retard</option>
        </select>
        <a href="{{ route('admin.prets.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            + Nouveau prêt
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
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
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($prets as $pret)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#{{ $pret->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-slate-900">{{ $pret->adherent->nom }} {{ $pret->adherent->prenom }}</div>
                        <div class="text-sm text-slate-500">{{ $pret->adherent->num_carte }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-slate-900">{{ $pret->exemplaire->ouvrage->titre }}</div>
                        <div class="text-sm text-slate-500">{{ $pret->exemplaire->code_barre }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $pret->date_emprunt->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $pret->date_retour_prevue->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($pret->statut === 'en_cours')
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-xl">En cours</span>
                        @elseif($pret->statut === 'rendu')
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-xl">Rendu</span>
                        @elseif($pret->statut === 'retard')
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-xl">En retard</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.prets.show', $pret->id) }}" class="text-blue-600 hover:text-blue-900">Voir</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-slate-500">Aucun prêt trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $prets->links() }}
</div>
