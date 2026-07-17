<div class="space-y-6">
    <!-- Header & Search -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/60 flex flex-col md:flex-row gap-4 items-center justify-between">
        
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="recherche"
                   placeholder="Titre, auteur, mot-clé..."
                   class="block w-full pl-11 pr-4 py-3 bg-slate-50 border-0 text-slate-900 rounded-2xl focus:ring-2 focus:ring-secondary focus:bg-white placeholder:text-slate-400 transition-all shadow-inner">
            <div wire:loading wire:target="recherche" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                <svg class="animate-spin h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select wire:model.live="categorie_id" class="w-full md:w-48 py-3 pl-4 pr-10 bg-slate-50 border-0 rounded-2xl text-slate-700 font-medium focus:ring-2 focus:ring-secondary focus:bg-white transition-all shadow-inner">
                <option value="0">Toutes catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                @endforeach
            </select>
            
            <select wire:model.live="disponibilite" class="w-full md:w-40 py-3 pl-4 pr-10 bg-slate-50 border-0 rounded-2xl text-slate-700 font-medium focus:ring-2 focus:ring-secondary focus:bg-white transition-all shadow-inner">
                <option value="">Tout voir</option>
                <option value="disponible">Disponible</option>
            </select>
        </div>
    </div>

    <!-- Results Grid -->
    <div>
        @if($ouvrages->isEmpty())
            <div class="py-20 text-center bg-white rounded-3xl border border-slate-200/60 border-dashed">
                <div class="w-20 h-20 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-xl font-medium text-slate-900 mb-2">Aucun livre trouvé</h3>
                <p class="text-slate-500">Essayez de modifier vos critères de recherche.</p>
                <button wire:click="$set('recherche', '')" class="mt-4 px-4 py-2 text-primary font-medium hover:bg-slate-50 rounded-xl transition-colors">Effacer la recherche</button>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($ouvrages as $ouvrage)
                    @php
                        $disponibles = $ouvrage->exemplaires->where('statut', 'disponible')->count();
                        $total = $ouvrage->exemplaires->count();
                    @endphp
                    <a href="{{ route('adherent.catalogue.show', $ouvrage->id) }}" class="group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-200/50">
                        <div class="aspect-[2/3] bg-slate-100 relative overflow-hidden">
                            @if($ouvrage->image_couverture)
                                <img src="{{ $ouvrage->image_url }}" alt="{{ $ouvrage->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 p-4 text-center">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-3 right-3 flex flex-col gap-2">
                                @if($disponibles > 0)
                                    <span class="bg-emerald-500/90 backdrop-blur text-white text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-xl shadow-sm flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-xl bg-white"></span> Disponible
                                    </span>
                                @else
                                    <span class="bg-amber-500/90 backdrop-blur text-white text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-xl shadow-sm flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-xl bg-white"></span> Emprunté
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-4">
                            @if($ouvrage->categories->isNotEmpty())
                                <p class="text-[10px] font-bold text-primary uppercase tracking-wider mb-1">{{ $ouvrage->categories->first()->nom }}</p>
                            @endif
                            <h3 class="font-poppins font-bold text-lg text-slate-900 leading-tight mb-1 line-clamp-2 group-hover:text-primary transition-colors" title="{{ $ouvrage->titre }}">
                                {{ $ouvrage->titre }}
                            </h3>
                            <p class="text-sm text-slate-500 line-clamp-1 mb-3">{{ $ouvrage->auteurs ?: 'Auteur inconnu' }}</p>
                            
                            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                                <span class="text-xs font-medium text-slate-400">{{ $disponibles }}/{{ $total }} ex.</span>
                                <span class="text-xs font-semibold text-primary flex items-center opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                                    Voir <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $ouvrages->links() }}
            </div>
        @endif
    </div>
</div>
