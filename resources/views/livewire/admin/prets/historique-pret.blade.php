<div>
    <div class="mb-4 flex gap-4">
        <input type="text" wire:model.live="recherche" class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Rechercher...">
        <select wire:model.live="action" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Toutes les actions</option>
            <option value="creation">Création</option>
            <option value="retour">Retour</option>
            <option value="prolongation">Prolongation</option>
            <option value="penalite">Pénalité</option>
        </select>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Prêt #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Détails</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($historique as $entry)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($entry->action === 'creation')
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Création</span>
                        @elseif($entry->action === 'retour')
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Retour</span>
                        @elseif($entry->action === 'prolongation')
                            <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 rounded-full">Prolongation</span>
                        @elseif($entry->action === 'penalite')
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Pénalité</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-800 rounded-full">{{ $entry->action }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#{{ $entry->pret_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $entry->utilisateur->name ?? 'Système' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-900">
                        @if($entry->details)
                            @if(is_array($entry->details))
                                @foreach($entry->details as $key => $value)
                                    <span class="text-xs">{{ $key }}: {{ $value }}</span><br>
                                @endforeach
                            @else
                                <span class="text-xs">{{ $entry->details }}</span>
                            @endif
                        @else
                            <span class="text-xs text-slate-500">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-slate-500">Aucun historique trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $historique->links() }}
</div>
