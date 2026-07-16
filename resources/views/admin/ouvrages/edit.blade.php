@extends('layouts.admin')

@section('title', 'Modifier — ' . $ouvrage->titre)
@section('header', 'Modifier l\'ouvrage')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Fil d'Ariane --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.ouvrages.index') }}" class="hover:text-indigo-600 transition-colors">Ouvrages</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.ouvrages.show', $ouvrage) }}" class="hover:text-indigo-600 transition-colors truncate max-w-xs">{{ $ouvrage->titre }}</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-800 font-medium">Modifier</span>
    </nav>

    <form method="POST" action="{{ route('admin.ouvrages.update', $ouvrage) }}" enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PUT')

        @error('general')
        <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">{{ $message }}</div>
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
                <div class="sm:col-span-2">
                    <label for="titre" class="block text-sm font-medium text-slate-700 mb-1.5">Titre <span class="text-red-500">*</span></label>
                    <input type="text" id="titre" name="titre" value="{{ old('titre', $ouvrage->titre) }}"
                           class="w-full px-4 py-2.5 rounded-xl border @error('titre') border-red-400 bg-red-50 @else border-slate-200 @enderror text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @error('titre')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="auteurs" class="block text-sm font-medium text-slate-700 mb-1.5">Auteur(s) <span class="text-red-500">*</span></label>
                    <input type="text" id="auteurs" name="auteurs" value="{{ old('auteurs', $ouvrage->auteurs) }}"
                           class="w-full px-4 py-2.5 rounded-xl border @error('auteurs') border-red-400 bg-red-50 @else border-slate-200 @enderror text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @error('auteurs')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="isbn" class="block text-sm font-medium text-slate-700 mb-1.5">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $ouvrage->isbn) }}"
                           class="w-full px-4 py-2.5 rounded-xl border @error('isbn') border-red-400 bg-red-50 @else border-slate-200 @enderror text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                    @error('isbn')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="editeur" class="block text-sm font-medium text-slate-700 mb-1.5">Éditeur</label>
                    <input type="text" id="editeur" name="editeur" value="{{ old('editeur', $ouvrage->editeur) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label for="langue" class="block text-sm font-medium text-slate-700 mb-1.5">Langue</label>
                    <select id="langue" name="langue"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                        @foreach(['Français', 'Anglais', 'Arabe', 'Wolof', 'Espagnol', 'Portugais', 'Autre'] as $lang)
                            <option value="{{ $lang }}" {{ old('langue', $ouvrage->langue) === $lang ? 'selected' : '' }}>{{ $lang }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="annee_publication" class="block text-sm font-medium text-slate-700 mb-1.5">Année de publication</label>
                    <input type="number" id="annee_publication" name="annee_publication"
                           value="{{ old('annee_publication', $ouvrage->annee_publication) }}"
                           min="1000" max="{{ date('Y') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label for="nombre_pages" class="block text-sm font-medium text-slate-700 mb-1.5">Nombre de pages</label>
                    <input type="number" id="nombre_pages" name="nombre_pages"
                           value="{{ old('nombre_pages', $ouvrage->nombre_pages) }}" min="1"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label for="format" class="block text-sm font-medium text-slate-700 mb-1.5">Format</label>
                    <select id="format" name="format"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                        <option value="">— Sélectionner —</option>
                        @foreach(['Broché', 'Relié', 'Poche', 'Grand format', 'PDF', 'Numérique'] as $fmt)
                            <option value="{{ $fmt }}" {{ old('format', $ouvrage->format) === $fmt ? 'selected' : '' }}>{{ $fmt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="actif" value="0">
                        <input type="checkbox" name="actif" value="1" id="actif"
                               {{ old('actif', $ouvrage->actif) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-slate-700">Ouvrage actif</span>
                    </label>
                </div>
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition resize-none">{{ old('description', $ouvrage->description) }}</textarea>
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
                @foreach($categories as $cat)
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="categories[]" value="{{ $cat['id'] }}"
                           {{ in_array($cat['id'], old('categories', $categoriesSelectionnees)) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-slate-700 group-hover:text-indigo-600 transition-colors">{{ $cat['label'] }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Section : Image --}}
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
                     class="w-24 h-32 bg-slate-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                    @if($ouvrage->image_couverture)
                        <img src="{{ $ouvrage->image_url }}" class="w-full h-full object-cover" alt="Couverture actuelle">
                    @else
                        <svg class="h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <label for="image_couverture"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl cursor-pointer transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        {{ $ouvrage->image_couverture ? 'Changer l\'image' : 'Choisir une image' }}
                    </label>
                    <input type="file" id="image_couverture" name="image_couverture"
                           accept="image/jpeg,image/png,image/webp" class="sr-only"
                           onchange="previewImage(this)">
                    <p class="text-xs text-slate-400 mt-2">JPG, PNG ou WebP · Max 2 Mo</p>
                    @error('image_couverture')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.ouvrages.show', $ouvrage) }}"
               class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer les modifications
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
            container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Aperçu">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
