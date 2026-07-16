@extends('layouts.admin')

@section('title', 'Ajouter un exemplaire')
@section('header', 'Ajouter un exemplaire')

@section('content')
<div class="max-w-2xl mx-auto">

    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.ouvrages.index') }}" class="hover:text-indigo-600 transition-colors">Ouvrages</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.ouvrages.show', $ouvrage) }}" class="hover:text-indigo-600 transition-colors truncate max-w-xs">{{ $ouvrage->titre }}</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-800 font-medium">Nouvel exemplaire</span>
    </nav>

    <form method="POST" action="{{ route('admin.ouvrages.exemplaires.store', $ouvrage) }}" class="space-y-5">
        @csrf
        <input type="hidden" name="ouvrage_id" value="{{ $ouvrage->id }}">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-5">

            <div class="p-3 bg-indigo-50 rounded-xl text-sm text-indigo-700">
                <span class="font-semibold">Ouvrage :</span> {{ $ouvrage->titre }}
            </div>

            <div>
                <label for="code_barre" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Code-barres
                    <span class="text-xs text-slate-400 ml-1">(généré automatiquement si vide)</span>
                </label>
                <input type="text" id="code_barre" name="code_barre" value="{{ old('code_barre') }}"
                       placeholder="BUD-000001-0001"
                       class="w-full px-4 py-2.5 rounded-xl border @error('code_barre') border-red-400 bg-red-50 @else border-slate-200 @enderror text-sm font-mono focus:ring-2 focus:ring-indigo-500 outline-none transition">
                @error('code_barre')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="cote" class="block text-sm font-medium text-slate-700 mb-1.5">Cote (localisation)</label>
                    <input type="text" id="cote" name="cote" value="{{ old('cote') }}"
                           placeholder="Ex : HUM/SOC/001"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label for="etat" class="block text-sm font-medium text-slate-700 mb-1.5">État de l'exemplaire</label>
                    <select id="etat" name="etat"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                        @foreach([5 => 'Neuf', 4 => 'Très bon', 3 => 'Bon', 2 => 'Passable', 1 => 'Mauvais'] as $val => $lab)
                            <option value="{{ $val }}" {{ old('etat', 5) == $val ? 'selected' : '' }}>{{ $val }} — {{ $lab }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="date_acquisition" class="block text-sm font-medium text-slate-700 mb-1.5">Date d'acquisition</label>
                    <input type="date" id="date_acquisition" name="date_acquisition"
                           value="{{ old('date_acquisition', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label for="prix_acquisition" class="block text-sm font-medium text-slate-700 mb-1.5">Prix (FCFA)</label>
                    <input type="number" id="prix_acquisition" name="prix_acquisition"
                           value="{{ old('prix_acquisition') }}" min="0" step="0.01"
                           placeholder="Ex : 15000"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
            </div>

            <div>
                <label for="fournisseur" class="block text-sm font-medium text-slate-700 mb-1.5">Fournisseur</label>
                <input type="text" id="fournisseur" name="fournisseur" value="{{ old('fournisseur') }}"
                       placeholder="Nom du fournisseur"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-slate-700 mb-1.5">Notes</label>
                <textarea id="notes" name="notes" rows="2"
                          placeholder="Remarques sur cet exemplaire…"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition resize-none">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.ouvrages.show', $ouvrage) }}"
               class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                Annuler
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Créer l'exemplaire
            </button>
        </div>
    </form>
</div>
@endsection
