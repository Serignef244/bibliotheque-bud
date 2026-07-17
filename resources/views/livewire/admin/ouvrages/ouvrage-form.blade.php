<div>
    {{-- Fil d'Ariane --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.ouvrages.index') }}" class="hover:text-indigo-600 transition-colors">Ouvrages</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        @if($ouvrage)
            <a href="{{ route('admin.ouvrages.show', $ouvrage) }}" class="hover:text-indigo-600 transition-colors truncate max-w-xs">{{ $ouvrage->titre }}</a>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-800 font-medium">Modifier</span>
        @else
            <span class="text-slate-800 font-medium">Nouvel ouvrage</span>
        @endif
    </nav>

    {{-- SECTION: RECHERCHE ISBN AUTOMATIQUE --}}
    <div class="bg-indigo-50/50 rounded-2xl shadow-sm border border-indigo-100 p-6 mb-6">
        <h2 class="text-base font-semibold text-indigo-900 mb-4 flex items-center gap-2">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Recherche automatique par ISBN
        </h2>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input type="text" wire:model="searchIsbn" wire:keydown.enter.prevent="search"
                       placeholder="Saisissez un ISBN (ex: 978-2-07-040850-4)"
                       class="w-full pl-4 pr-4 py-3 rounded-xl border border-indigo-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition shadow-sm">
                
                @if($erreur)
                    <p class="absolute -bottom-6 left-0 text-xs text-red-500">{{ $erreur }}</p>
                @endif
            </div>
            
            <button type="button" wire:click="search" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="search">Rechercher</span>
                <span wire:loading wire:target="search" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Recherche...
                </span>
            </button>
        </div>

        {{-- Résultat de la recherche --}}
        @if($resultat)
            <div class="mt-6 p-4 bg-white rounded-xl border border-indigo-100 shadow-sm flex flex-col sm:flex-row gap-6 animate-in fade-in slide-in-from-top-2 duration-300">
                {{-- Aperçu de la couverture --}}
                <div class="w-24 h-36 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center border border-slate-200">
                    @if(!empty($resultat['couverture']))
                        <img src="{{ asset('storage/' . $resultat['couverture']) }}" class="w-full h-full object-cover" alt="Couverture">
                    @else
                        <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>
                
                {{-- Données --}}
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-slate-800">{{ $resultat['titre'] ?? 'Titre inconnu' }}</h3>
                    <p class="text-sm font-medium text-slate-600 mb-2">{{ $resultat['auteur'] ?? 'Auteur inconnu' }}</p>
                    
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500 mb-4">
                        @if(!empty($resultat['editeur']))
                            <span class="flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                {{ $resultat['editeur'] }}
                            </span>
                        @endif
                        @if(!empty($resultat['annee_publication']))
                            <span class="flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $resultat['annee_publication'] }}
                            </span>
                        @endif
                        @if(!empty($resultat['isbn']))
                            <span class="flex items-center gap-1 font-mono">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                {{ $resultat['isbn'] }}
                            </span>
                        @endif
                        <span class="text-indigo-500 font-medium ml-auto border border-indigo-200 bg-indigo-50 px-2 py-0.5 rounded">Source : {{ $resultat['source'] ?? 'API' }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" wire:click="importerData"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Importer les données
                        </button>
                        <button type="button" wire:click="ignorerData"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 text-sm font-medium rounded-lg transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Ignorer
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- FORMULAIRE CLASSIQUE WRAPPÉ --}}
    <form method="POST" action="{{ $ouvrage ? route('admin.ouvrages.update', $ouvrage) : route('admin.ouvrages.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($ouvrage)
            @method('PUT')
        @endif
        
        {{-- Champ caché pour la couverture récupérée de l'API --}}
        <input type="hidden" name="image_couverture_url" wire:model="image_couverture_url">

        {{-- Erreur globale --}}
        @error('general')
        <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            {{ $message }}
        </div>
        @enderror

        {{-- Section : Informations principales --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                Informations principales
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Titre --}}
                <div class="sm:col-span-2">
                    <label for="titre" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Titre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="titre" name="titre" wire:model="titre"
                           placeholder="Titre complet de l'ouvrage"
                           class="w-full px-4 py-2.5 rounded-xl border @error('titre') border-red-400 bg-red-50 @else border-slate-200 @enderror text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @error('titre')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Auteurs --}}
                <div class="sm:col-span-2">
                    <label for="auteurs" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Auteur(s) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="auteurs" name="auteurs" wire:model="auteurs"
                           placeholder="Ex : Jean Dupont, Marie Martin"
                           class="w-full px-4 py-2.5 rounded-xl border @error('auteurs') border-red-400 bg-red-50 @else border-slate-200 @enderror text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    <p class="mt-1 text-xs text-slate-400">Séparez plusieurs auteurs par des virgules.</p>
                    @error('auteurs')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- ISBN --}}
                <div>
                    <label for="isbn" class="block text-sm font-medium text-slate-700 mb-1.5">ISBN</label>
                    <input type="text" id="isbn" name="isbn" wire:model="isbn"
                           placeholder="978-XXXXXXXXXX"
                           class="w-full px-4 py-2.5 rounded-xl border @error('isbn') border-red-400 bg-red-50 @else border-slate-200 @enderror text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @error('isbn')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Éditeur --}}
                <div>
                    <label for="editeur" class="block text-sm font-medium text-slate-700 mb-1.5">Éditeur</label>
                    <input type="text" id="editeur" name="editeur" wire:model="editeur"
                           placeholder="Nom de l'éditeur"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>

                {{-- Langue --}}
                <div>
                    <label for="langue" class="block text-sm font-medium text-slate-700 mb-1.5">Langue</label>
                    <select id="langue" name="langue"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                        @foreach(['Français', 'Anglais', 'Arabe', 'Wolof', 'Espagnol', 'Portugais', 'Autre'] as $lang)
                            <option value="{{ $lang }}" {{ old('langue', $ouvrage ? $ouvrage->langue : 'Français') === $lang ? 'selected' : '' }}>{{ $lang }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Année --}}
                <div>
                    <label for="annee_publication" class="block text-sm font-medium text-slate-700 mb-1.5">Année de publication</label>
                    <input type="number" id="annee_publication" name="annee_publication" wire:model="annee_publication"
                           min="1000" max="{{ date('Y') }}" placeholder="{{ date('Y') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>

                {{-- Pages --}}
                <div>
                    <label for="nombre_pages" class="block text-sm font-medium text-slate-700 mb-1.5">Nombre de pages</label>
                    <input type="number" id="nombre_pages" name="nombre_pages" wire:model="nombre_pages"
                           min="1" placeholder="Ex : 320"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>

                {{-- Format --}}
                <div>
                    <label for="format" class="block text-sm font-medium text-slate-700 mb-1.5">Format</label>
                    <select id="format" name="format"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                        <option value="">— Sélectionner —</option>
                        @foreach(['Broché', 'Relié', 'Poche', 'Grand format', 'PDF', 'Numérique'] as $fmt)
                            <option value="{{ $fmt }}" {{ old('format', $ouvrage ? $ouvrage->format : '') === $fmt ? 'selected' : '' }}>{{ $fmt }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Description --}}
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description / Résumé</label>
                    <textarea id="description" name="description" wire:model="description" rows="4"
                              placeholder="Résumé de l'ouvrage…"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition resize-none"></textarea>
                </div>
                <div class="flex items-center gap-3 sm:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="actif" value="0">
                        <input type="checkbox" name="actif" value="1" id="actif"
                               {{ old('actif', $ouvrage ? $ouvrage->actif : true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Ouvrage actif</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Section : Catégories --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </span>
                Catégories
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($categoriesDisponibles as $cat)
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="categories[]" value="{{ $cat['id'] }}" wire:model="categoriesSelectionnees"
                           class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-slate-700 group-hover:text-indigo-600 transition-colors">{{ $cat['label'] }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Section : Image de couverture --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-800 mb-5 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                Image de couverture
            </h2>
            <div class="flex items-center gap-6">
                <div id="preview-container"
                     class="w-24 h-32 bg-slate-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0 border border-slate-200 relative">
                    
                    @if($image_couverture_url)
                        <img src="{{ asset('storage/' . $image_couverture_url) }}" class="w-full h-full object-cover" alt="Aperçu importé">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white text-xs font-semibold px-2 text-center">Image importée</span>
                        </div>
                    @elseif($ouvrage && $ouvrage->image_couverture)
                        <img src="{{ $ouvrage->image_url }}" class="w-full h-full object-cover" alt="Couverture actuelle">
                    @else
                        <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <label for="image_couverture"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl cursor-pointer transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Choisir une image manuellement
                    </label>
                    <input type="file" id="image_couverture" name="image_couverture"
                           accept="image/jpeg,image/png,image/webp" class="sr-only"
                           onchange="previewImage(this)">
                    <p class="text-xs text-slate-400 mt-2">JPG, PNG ou WebP · Max 2 Mo. Remplacera l'image importée si sélectionné.</p>
                    @error('image_couverture')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ $ouvrage ? route('admin.ouvrages.show', $ouvrage) : route('admin.ouvrages.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ $ouvrage ? 'Enregistrer les modifications' : 'Créer l\'ouvrage' }}
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const container = document.getElementById('preview-container');
            container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Aperçu manuel">`;
            
            // Optionally tell Livewire to clear the imported url so we know we use the file
            // @this.set('image_couverture_url', ''); // Uncomment if needed, but the controller handles file > url
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
