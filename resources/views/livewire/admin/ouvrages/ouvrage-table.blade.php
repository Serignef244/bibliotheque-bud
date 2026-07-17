<div class="space-y-6">

    {{-- Barre de filtres (Livewire) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Recherche --}}
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Recherche</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="recherche"
                           placeholder="Titre, auteur, ISBN…"
                           class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>
            </div>

            {{-- Catégorie --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Catégorie</label>
                <select wire:model.live="categorie_id"
                        class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    <option value="">Toutes</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Disponibilité --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Disponibilité</label>
                <select wire:model.live="disponible"
                        class="w-full py-2.5 px-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    <option value="">Tous</option>
                    <option value="1">Disponibles</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-4">
            <button wire:click="resetFilters" type="button"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition-colors">
                Réinitialiser
            </button>

            @can('create', \App\Models\Ouvrage::class)
            <div class="ml-auto flex gap-3">
                <a href="{{ route('admin.categories.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Catégories
                </a>
                <a href="{{ route('admin.ouvrages.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvel ouvrage
                </a>
            </div>
            @endcan
        </div>
    </div>

    {{-- Résultats --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
        
        <div wire:loading.delay.longer class="absolute inset-0 bg-white/50 backdrop-blur-sm z-10 flex items-center justify-center">
            <div class="animate-spin rounded-xl h-8 w-8 border-b-2 border-indigo-600"></div>
        </div>

        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <p class="text-sm text-slate-500">
                <span class="font-semibold text-slate-800">{{ $ouvrages->total() }}</span> ouvrage{{ $ouvrages->total() > 1 ? 's' : '' }} trouvé{{ $ouvrages->total() > 1 ? 's' : '' }}
            </p>
        </div>

        @if($ouvrages->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-slate-500 font-medium">Aucun ouvrage trouvé</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($ouvrages as $ouvrage)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group">
                    {{-- Couverture --}}
                    <div class="flex-shrink-0">
                        @if($ouvrage->image_couverture)
                            <img src="{{ $ouvrage->image_url }}" alt="{{ $ouvrage->titre }}"
                                 class="w-12 h-16 object-cover rounded-lg shadow-sm">
                        @else
                            <div class="w-12 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Infos --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start gap-2">
                            <h3 class="font-semibold text-slate-800 truncate">{{ $ouvrage->titre }}</h3>
                            @if(! $ouvrage->actif)
                                <span class="flex-shrink-0 inline-flex items-center px-2 py-0.5 rounded-xl text-xs font-medium bg-slate-100 text-slate-500">
                                    Inactif
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $ouvrage->auteurs_principal }}</p>
                        <div class="flex items-center flex-wrap gap-2 mt-1.5">
                            @foreach($ouvrage->categories->take(3) as $cat)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-xl text-xs font-medium bg-indigo-50 text-indigo-700">
                                    {{ $cat->nom }}
                                </span>
                            @endforeach
                            @if($ouvrage->isbn)
                                <span class="text-xs text-slate-400">ISBN: {{ $ouvrage->isbn }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Disponibilité --}}
                    <div class="flex-shrink-0 text-center hidden sm:block">
                        <div class="text-2xl font-bold {{ $ouvrage->est_disponible ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $ouvrage->nombre_exemplaires_disponibles }}
                        </div>
                        <div class="text-xs text-slate-400">/ {{ $ouvrage->nombre_exemplaires_total }}</div>
                        <div class="text-xs {{ $ouvrage->est_disponible ? 'text-emerald-500' : 'text-red-400' }} font-medium mt-0.5">
                            {{ $ouvrage->est_disponible ? 'Disponible' : 'Indisponible' }}
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex-shrink-0 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.ouvrages.show', $ouvrage) }}"
                           class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Voir">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @can('update', $ouvrage)
                        <a href="{{ route('admin.ouvrages.edit', $ouvrage) }}"
                           class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Modifier">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        @endcan
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($ouvrages->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $ouvrages->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
